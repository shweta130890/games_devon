<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Players;
use App\Service\PlayerService;
use App\Service\Utils\StatusCode;

/**
 * Player controller.
 * @Route("/api", name="api_")
 */
class PlayerController extends CommonApiController
{
    /**
     * Lists all players.
     * @Rest\Get("/players")
     *
     * @return Response
     */
    public function getPlayerAction()
    {
        $em = $this->getEntityManager();
        $service = new PlayerService($em);
        $players = $service->getPlayers();

        return $this->handleView(
            $this->view(
                [
                    $players
                ],
                Response::HTTP_OK
            )
        );
    }

    /**
     * Create Player.
     * @Rest\Post("/player")
     *
     * @return Response
     */
    public function postPlayerAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $data = $this->sanitizeInput($data);

        $em = $this->getEntityManager();
        $service = new PlayerService($em);
        $result = $service->createPlayer($data);
        if ($result["CODE"] == StatusCode::SUCCESS) {
            return $this->handleView($this->view($result, Response::HTTP_OK));
        } else {
            return $this->handleView($this->view($result, Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * @param array $data
     * @return array|string
     */
    public function sanitizeInput(array $data)
    {
        $onlyString = ['firstname', 'lastname'];
        $onlyUrl = ['imageUri'];
        $onlyEmail = ['username'];

        foreach ($data as $field => $value) {
            if (in_array($field, $onlyString)) {
                $data[$field] = $this->sanitizeClass->onlyString($value);
            }
            if (in_array($field, $onlyUrl)) {
                $data[$field] = $this->sanitizeClass->onlyUrl($value);
            }
            if (in_array($field, $onlyEmail)) {
                $data[$field] = $this->sanitizeClass->onlyEmail($value);
            }
        }
        return $data;
    }
    /**
     * Create Player.
     * @Rest\Put("/player/{id}")
     *
     * @return Response
     */
//    public function putPlayerAction(Request $request)
//    {
//        $data = json_decode($request->getContent(), true);
//        $player = $this->getDoctrine()->getRepository(Players::class)->find($request->get('id'));
//        $player->setFirstname($data['firstname']);
//        $player->setLastname($data['lastname']);
//        $player->setImageUri($data['imageUri']);
//        $player->setStatus(1);
//        $player->setUpdatedDt(new \DateTime('now'));
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($player);
//        $em->flush();
//        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
//    }
}