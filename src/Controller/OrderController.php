<?php
 namespace App\Controller;

 use App\Entity\Order;
 use App\Repository\OrderRepository;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
 

 /**
  * Class OrderController
  * @package App\Controller
  * @Route("/api", name="order_api")
  */
 class OrderController extends AbstractController
 {
  /**
   * @param OrderController $orderRepository
   * @return JsonResponse
   * @Route("/orders", name="orders", methods={"GET"})
   */
   public function getOrders(OrderRepository $orderRepository){
   $data = $orderRepository->findAll();
   return $this->response($data);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param OrderRepository $orderRepository
   * @return JsonResponse
   * @throws \Exception
   * @Route("/orders", name="orders_add", methods={"POST"})
   */
  public function addOrder(Request $request, EntityManagerInterface $entityManager, OrderRepository $orderRepository){

   try{
    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('productid') || !$request->request->get('quantity')){
     throw new \Exception();
    }
    
    $order = new Order();
    $order->setproductid($request->get('productid'));
    $order->setquantity($request->get('quantity'));
    $order->setaddress($request->get('address'));
    $date=$request->get('shippingDate');$date = \DateTime::createFromFormat('Ymd', $date);
    $order->setshippingDate($date);

    $entityManager->persist($order);
    $entityManager->flush();

    $data = [
     'status' => 200,
     'success' => "Order added successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Data no valid",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param OrderRepository $orderRepository
   * @param $id
   * @return JsonResponse
   * @Route("/orders/{id}", name="orders_get", methods={"GET"})
   */
  public function getOrder(OrderRepository $orderRepository, $id){
   $order = $orderRepository->find($id);

   if (!$order){
    $data = [
     'status' => 404,
     'errors' => "Order not found",
    ];
    return $this->response($data, 404);
   }
   return $this->response($order);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param OrderRepository $orderRepository
   * @param $id
   * @return JsonResponse
   * @Route("/orders/{id}", name="orders_put", methods={"PUT"})
   */
  public function updateOrder(Request $request, EntityManagerInterface $entityManager, OrderRepository $orderRepository, $id){

   try{
    $order = $orderRepository->find($id);

    if (!$order){
     $data = [
      'status' => 404,
      'errors' => "Order not found",
     ];
     return $this->response($data, 404);
    }

    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('productid') || !$request->request->get('quantity')){
     throw new \Exception();
    }
    $ordercheck = $orderRepository->find($id);  
    $datecheck=$ordercheck->getshippingDate(); $datecheck=$datecheck->format('Ymd'); $today=date('Ymd');    
    if($datecheck<$today)
    {
    $order->setproductid($request->get('productid'));
    $order->setquantity($request->get('quantity'));
    $order->setaddress($request->get('address'));
    $date=$request->get('shippingDate');$date = \DateTime::createFromFormat('Ymd', $date);
    $order->setshippingDate($date);
    $entityManager->flush();

    $data = [
     'status' => 200,
     'errors' => "Order updated successfully",
    ];
    return $this->response($data);
     } else{return $this->response("Shippingdate bugünden önce olmalı");}
   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Data no valid",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param OrderRepository $orderRepository
   * @param $id
   * @return JsonResponse
   * @Route("/orders/{id}", name="orders_delete", methods={"DELETE"})
   */
  public function deleteOrder(EntityManagerInterface $entityManager, OrderRepository $orderRepository, $id){
   $order = $orderRepository->find($id);

   if (!$order){
    $data = [
     'status' => 404,
     'errors' => "Order not found",
    ];
    return $this->response($data, 404);
   }

   $entityManager->remove($order);
   $entityManager->flush();
   $data = [
    'status' => 200,
    'errors' => "Order deleted successfully",
   ];
   return $this->response($data);
  }





  /**
   * Returns a JSON response
   *
   * @param array $data
   * @param $status
   * @param array $headers
   * @return JsonResponse
   */
  public function response($data, $status = 200, $headers = [])
  {
   return new JsonResponse($data, $status, $headers);
  }

  protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
  {
   $data = json_decode($request->getContent(), true);

   if ($data === null) {
    return $request;
   }

   $request->request->replace($data);

   return $request;
  }

 }