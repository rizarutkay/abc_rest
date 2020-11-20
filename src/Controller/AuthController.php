<?php
 namespace App\Controller;


 use App\Entity\User;
 use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
 use Symfony\Component\Security\Core\User\UserInterface;

 class AuthController extends ApiController
 {

  public function register(Request $request, UserPasswordEncoderInterface $encoder)
  {
   $em = $this->getDoctrine()->getManager();
   $request = $this->transformJsonBody($request);
   $username = $request->get('username');
   $password = $request->get('password');


   if (empty($username) || empty($password) ){
    return $this->respondValidationError("Invalid Username or Password");
   }


   $user = new User($username);
   $user->setPassword($encoder->encodePassword($user, $password));
   $user->setUsername($username);
   $em->persist($user);
   $em->flush();
   return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
  }

  /**
   * @param UserInterface $user
   * @param JWTTokenManagerInterface $JWTManager
   * @return JsonResponse
   */
  public function getTokenUser(Request $request, UserInterface $user = null, JWTTokenManagerInterface $JWTManager)
  {
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
  return new JsonResponse(['token' => $JWTManager->create($user)]);
  }else{
  return new Response('Invalid api request. Please use json format', Response::HTTP_NOT_FOUND);
  }
  }

 }