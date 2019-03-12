<?php
namespace App\Service;

use App\Entity\Players;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Service\Utils\StatusCode;

/**
 * Class PlayerService
 * @package App\Service
 */
class PlayerService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * PlayerService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array|object[]
     */
    public function getPlayers()
    {
        $repository = $this->em->getRepository(Players::class);
        return $repository->findall();
    }

    /**
     * @param array $data
     * @return bool|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPlayer(array $data)
    {
        $player = new Players();
        $player->setUsername($data['username']);
        $player->setFirstname($data['firstname']);
        $player->setLastname($data['lastname']);
        $player->setImageUri($data['imageUri']);
        $player->setStatus(Players::STATUS_ACTIVE);

        $em = $this->em;
        $em->persist($player);

        try {
            $em->flush();
            $resultArr = [
                "MESSAGE" => "Successfully Player added!!",
                "CODE" => StatusCode::SUCCESS
            ];
        } catch (UniqueConstraintViolationException $e) {
            $resultArr = [
                "MESSAGE" => "Player username already exist!!",
                "CODE" => StatusCode::DUPLICATE
            ];
        }

        return $resultArr;
    }
}