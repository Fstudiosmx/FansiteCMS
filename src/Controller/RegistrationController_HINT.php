<?php
// src/Controller/RegistrationController.php  — FRAGMENTO ORIENTATIVO
// Agrega esta lógica en el método de registro ANTES de persistir el usuario

// use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use Symfony\Component\HttpClient\HttpClient;

// 1. Generar (o recuperar de sesión) el token de misión
// $mottoToken = $session->get('motto_token') ?? 'HS-' . strtoupper(bin2hex(random_bytes(5)));
// $session->set('motto_token', $mottoToken);

// 2. Si el formulario fue enviado, verificar la misión vía API Habbo.es
// if ($form->isSubmitted() && $form->isValid()) {
//     $username = $form->get('username')->getData();
//     $client   = HttpClient::create();
//     $response = $client->request('GET', 'https://www.habbo.es/api/public/users', [
//         'query' => ['name' => $username],
//     ]);
//     if ($response->getStatusCode() === 200) {
//         $habboData = $response->toArray();
//         if (($habboData['motto'] ?? '') !== $mottoToken) {
//             $this->addFlash('error', 'Tu misión en Habbo.es no coincide.');
//             return $this->renderForm('register/index.html.twig', [
//                 'register_form' => $form,
//                 'motto_token'   => $mottoToken,
//             ]);
//         }
//         $user->setMotto($habboData['motto']);
//         $user->setMemberSince(new \DateTime($habboData['memberSince']));
//         $session->remove('motto_token');
//         // ... persistir usuario, encodear contraseña, etc.
//     }
// }
