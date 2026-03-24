// Lightweight network/node background for the home hero
(function () {
    const canvas = document.getElementById('home-network-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = 0;
    let height = 0;
    let dpr = Math.max(1, window.devicePixelRatio || 1);

    const config = {
        density: 6000, // px per particle
        maxLinksDistance: 140,
        nodeMin: 18,
        nodeMax: 60,
        nodeRadius: 1.6,
        speed: 0.2,
        lineWidth: 1,
        nodeColor: 'rgba(255,211,0,0.9)',
        lineColor: 'rgba(255,255,255,0.07)'
    };

    let nodes = [];
    let mouse = { x: null, y: null, active: false };

    function resize() {
        dpr = Math.max(1, window.devicePixelRatio || 1);
        width = canvas.clientWidth || canvas.parentElement.clientWidth || window.innerWidth;
        height = canvas.clientHeight || canvas.parentElement.clientHeight || 300;
        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        initNodes();
    }

    function initNodes() {
        const count = Math.max(config.nodeMin, Math.min(config.nodeMax, Math.floor((width * height) / config.density)));
        nodes = [];
        for (let i = 0; i < count; i++) {
            nodes.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * config.speed,
                vy: (Math.random() - 0.5) * config.speed,
                r: config.nodeRadius * (0.8 + Math.random() * 0.6)
            });
        }
    }

    function step() {
        ctx.clearRect(0, 0, width, height);

        // update positions
        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            n.x += n.vx;
            n.y += n.vy;

            // bounce
            if (n.x < 0 || n.x > width) n.vx *= -1;
            if (n.y < 0 || n.y > height) n.vy *= -1;

            // slight attraction to mouse
            if (mouse.active) {
                const dx = mouse.x - n.x;
                const dy = mouse.y - n.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < config.maxLinksDistance * 1.25) {
                    const force = (1 - dist / (config.maxLinksDistance * 1.25)) * 0.03;
                    n.vx += dx * force;
                    n.vy += dy * force;
                }
            }
        }

        // draw links
        ctx.lineWidth = config.lineWidth;
        ctx.strokeStyle = config.lineColor;
        ctx.beginPath();
        for (let i = 0; i < nodes.length; i++) {
            const a = nodes[i];
            for (let j = i + 1; j < nodes.length; j++) {
                const b = nodes[j];
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < config.maxLinksDistance) {
                    const alpha = 1 - dist / config.maxLinksDistance;
                    ctx.strokeStyle = `rgba(255,255,255,${0.06 * alpha})`;
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                }
            }
            // link to mouse
            if (mouse.active) {
                const dxm = a.x - mouse.x;
                const dym = a.y - mouse.y;
                const distm = Math.sqrt(dxm * dxm + dym * dym);
                if (distm < config.maxLinksDistance) {
                    const alpha = 1 - distm / config.maxLinksDistance;
                    ctx.strokeStyle = `rgba(255,255,255,${0.08 * alpha})`;
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(mouse.x, mouse.y);
                }
            }
        }
        ctx.stroke();

        // draw nodes
        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            ctx.beginPath();
            ctx.fillStyle = config.nodeColor;
            ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
            ctx.fill();
        }

        requestAnimationFrame(step);
    }

    // mouse handling
    function onMove(e) {
        const rect = canvas.getBoundingClientRect();
        const x = (e.clientX || (e.touches && e.touches[0] && e.touches[0].clientX)) - rect.left;
        const y = (e.clientY || (e.touches && e.touches[0] && e.touches[0].clientY)) - rect.top;
        mouse.x = x;
        mouse.y = y;
        mouse.active = true;
    }

    function onLeave() {
        mouse.active = false;
        mouse.x = null;
        mouse.y = null;
    }

    window.addEventListener('resize', resize, { passive: true });
    canvas.addEventListener('mousemove', onMove);
    canvas.addEventListener('touchmove', onMove, { passive: true });
    canvas.addEventListener('mouseleave', onLeave);
    canvas.addEventListener('touchend', onLeave);

    // initialize when element is ready
    function ready() {
        resize();
        requestAnimationFrame(step);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ready);
    } else {
        ready();
    }

})();
