<?php

namespace App\Controllers;

use App\Libraries\Sendmail;

class Contact extends BaseController
{
    public function index(): string
    {
        session()->set('contact_form_ts', time());

        $data['title']       = 'Contact';
        $data['css']         = ['contact'];
        $data['js']          = ['home-hero-network'];
        $data['discord_url'] = config('Discord')->inviteURL;

        return view('contact', $data);
    }

    public function send(): \CodeIgniter\HTTP\RedirectResponse
    {
        // Anti-bot: honeypot field must remain blank
        if ($this->request->getPost('website') !== '') {
            return redirect()->to('/contact')->with('error', 'Submission rejected.');
        }

        // Anti-bot: minimum submission time — prevents instant bot submissions
        $formTs = session()->get('contact_form_ts');
        if (! $formTs || (time() - (int) $formTs) < 3) {
            return redirect()->to('/contact')
                ->with('error', 'Please take a moment to fill in the form.');
        }

        // Anti-bot: rate limiting — max 3 submissions per hour per session
        $submissions = session()->get('contact_submissions') ?? [];
        $now         = time();
        $submissions = array_values(
            array_filter($submissions, static fn(int $ts): bool => ($now - $ts) < 3600)
        );

        if (count($submissions) >= 3) {
            return redirect()->to('/contact')
                ->with('error', 'You have sent too many messages recently. Please try again later.');
        }

        // Input validation
        $rules = [
            'name'    => 'required|min_length[2]|max_length[100]',
            'email'   => 'required|valid_email|max_length[254]',
            'message' => 'required|min_length[10]|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/contact')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name    = $this->request->getPost('name');
        $email   = $this->request->getPost('email');
        $message = $this->request->getPost('message');

        $body  = "Name: {$name}\n";
        $body .= "Email: {$email}\n\n";
        $body .= "Message:\n{$message}";

        try {
            (new Sendmail())
                ->setFrom(config('Email')->fromEmail)
                ->setTo(config('Email')->toEmail)
                ->setSubject("Contact form message from {$name}")
                ->setBody($body)
                ->send();
        } catch (\Exception $e) {
            log_message('error', 'Contact form send failed: ' . $e->getMessage());
            return redirect()->to('/contact')
                ->with('error', 'Sorry, there was a problem sending your message. Please try again later.');
        }

        // Record submission timestamp for rate limiting
        $submissions[] = $now;
        session()->set('contact_submissions', $submissions);
        session()->remove('contact_form_ts');

        return redirect()->to('/contact')
            ->with('success', "Your message has been sent. I'll get back to you as soon as possible!");
    }
}
