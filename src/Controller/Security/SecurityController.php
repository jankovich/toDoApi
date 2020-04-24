<?php

namespace App\Controller\Security;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SecurityController
{

    private $security;

    public function __construct(Security $security, UserRepository $repository)
    {
        $this->security = $security;
        $this->repository = $repository;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->security->getUser();
        return new JsonResponse(['status' => 'Logged in'], Response::HTTP_OK);
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['username']) || empty($data['password'])) {
            return new JsonResponse(['status' => 'Missing required parameters'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->repository->new($data['username'], $data['password']);

        return new JsonResponse(['status' => 'User created'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {
    }
}