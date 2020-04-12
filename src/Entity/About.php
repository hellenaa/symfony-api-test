<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     collectionOperations={
 *         "get" = {
 *             "path"="/admin/about",
 *             "method"="GET",
 *         },
 *     },
 *     itemOperations={
 *       "get" = {
 *           "path"="admin/about/{id}",
 *           "method"="GET",
 *        }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AboutRepository")
 * @UniqueEntity(
 *     fields={"id"}
 * )
 */
class About
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    public $id;

    /**
     * @ORM\Column(type="text", name="text_arm")
     * @Assert\NotBlank(message="Text can't be empty")
     */
    private $textArm;

    /**
     * @ORM\Column(type="text", name="text_rus")
     * @Assert\NotBlank(message="Text can't be empty")
     */
    private $textRus;

    /**
     * @ORM\Column(type="text", name="text_eng")
     * @Assert\NotBlank(message="Text can't be empty")
     */
    private $textEng;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Status can't be empty")
     */
    private $status;


    public function __construct() {
        $this->id = Uuid::uuid4();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTextEng()
    {
        return $this->textEng;
    }

    public function setTextEng($textEng): void
    {
        $this->textEng = $textEng;
    }

    public function getTextRus()
    {
        return $this->textRus;
    }

    public function setTextRus($textRus): void
    {
        $this->textRus = $textRus;
    }

    public function getTextArm()
    {
        return $this->textArm;
    }

    public function setTextArm($textArm): void
    {
        $this->textArm = $textArm;
    }

}
