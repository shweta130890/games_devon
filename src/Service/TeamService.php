<?php

namespace App\Service;

use App\Entity\Team;
use App\Entity\Players;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Service\Utils\StatusCode;

/**
 * Class TeamService
 * @package App\Service
 */
class TeamService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * TeamService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return array|object[]|string
     */
    public function getAllPlayers(int $id)
    {
        $em = $this->em;
        $team = $em->getRepository(Team::class)->find($id);

        if(!$team) {
            return [
                "MESSAGE" => "Team does not exist!!",
                "CODE" => StatusCode::NOT_EXIST
            ];
        }

        return [
            "DATA" => $team,
            "CODE" => StatusCode::SUCCESS
        ];
//        return $team->getPlayers();
    }

    /**
     * @param array $data
     * @return bool|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTeam(array $data)
    {
        $team = new Team();
        $team->setName($data['name']);
        $team->setLogoUri($data['logoUri']);
        $team->setStatus(Team::STATUS_ACTIVE);

        foreach ($data['players'] as $id) {
            $playerObj = $this->em->getRepository(Players::class)->find($id);
            if ($playerObj) {
                if ($playerObj->getTeamId() != null) {
                    return [
                        "MESSAGE" => "These Players already allocated to another team!!",
                        "CODE" => StatusCode::ALREADY_EXIST
                    ];
                }
                $team->addPlayer($playerObj);
            } else {
                return [
                    "MESSAGE" => "Players does not exist!!",
                    "CODE" => StatusCode::NOT_EXIST
                ];
            }
        }

        $em = $this->em;
        $em->persist($team);
        try {
            $em->flush();
            $resultArr = [
                "MESSAGE" => "Successfully Team created!!",
                "CODE" => StatusCode::SUCCESS
            ];
        } catch (UniqueConstraintViolationException $e) {
            $resultArr = [
                "MESSAGE" => "Team name already exist!!",
                "CODE" => StatusCode::DUPLICATE
            ];
        }

        return $resultArr;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTeam(int $id)
    {
        $em = $this->em;
        $team = $em->getRepository(Team::class)->find($id);
        if(!$team) {
            return [
                "MESSAGE" => "Team does not exist!!",
                "CODE" => StatusCode::NOT_EXIST
            ];
        }
        $team->setStatus(Team::STATUS_DELETED);
        $team->setUpdatedDt(new \DateTime('now'));

        foreach ($team->getPlayers() as $player) {
            $team->removePlayer($player);
        }

        $em->persist($team);
        $em->flush();
        return [
            "MESSAGE" => "Successfully deleted!!",
            "CODE" => StatusCode::SUCCESS
        ];
    }
}