<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Team;
use App\Service\TeamService;
use App\Service\Utils\StatusCode;

/**
 * Team controller.
 * @Route("/api", name="api_")
 */
class TeamController extends CommonApiController
{

    /**
     * Create Team.
     * @Rest\Post("/team")
     *
     * @return Response
     */
    public function postTeamAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $data = $this->sanitizeInput($data);

        $em = $this->getEntityManager();
        $service = new TeamService($em);
        $result = $service->createTeam($data);

        if ($result["CODE"] == StatusCode::SUCCESS) {
            return $this->handleView($this->view($result, Response::HTTP_OK));
        } else {
            return $this->handleView($this->view([$result], Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * Lists all team.
     * @Rest\Get("/team/{id}")
     *
     * @return Response
     */

    public function getTeamAction(Request $request)
    {
        $id = $this->sanitizeClass->onlyInteger($request->get('id'));

        $em = $this->getEntityManager();
        $service = new TeamService($em);
        $result = $service->getAllPlayers($id);

        if ($result["CODE"] == StatusCode::SUCCESS) {
            return $this->handleView($this->view($result["DATA"] , Response::HTTP_OK));
        } else {
            return $this->handleView($this->view([$result], Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * Delete Team.
     * @Rest\Delete("/delete/team/{id}")
     *
     * @return Response
     */
    public function deleteTeamAction(Request $request)
    {
        $id = $this->sanitizeClass->onlyInteger($request->get('id'));

        $em = $this->getEntityManager();
        $team = new TeamService($em);
        $result = $team->deleteTeam($id);

        return $this->handleView($this->view([$result], Response::HTTP_OK));
    }

    /**
     * Create Team.
     * @Rest\Put("/team/{id}")
     *
     * @return Response
     */
    public function putTeamAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $player = $this->getDoctrine()->getRepository(Teams::class)->find($request->get('id'));
        $player->setName($data['name']);
        $player->setLogoUri($data['logoUri']);
        $player->setStatus(1);
        $player->setUpdatedDt(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * @param array $data
     * @return array|string
     */
    public function sanitizeInput(array $data)
    {
        $onlyString = ['name'];
        $onlyUrl = ['logoUri'];

        foreach ($data as $field => $value) {
            if (in_array($field, $onlyString)) {
                $data[$field] = $this->sanitizeClass->onlyString($value);
            }
            if (in_array($field, $onlyUrl)) {
                $data[$field] = $this->sanitizeClass->onlyUrl($value);
            }
        }
        return $data;
    }
}