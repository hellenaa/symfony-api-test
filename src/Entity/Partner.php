<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity
 * @ApiResource(
 *     itemOperations={
 *        "get" = {
 *             "path"="/admin/partner/{id}",
 *             "method"="GET",
 *              "normalization_context"={
 *                "groups"={"getPartner"}
 *              }
 *         },
 *     },
 *     collectionOperations={
 *         "get" = {
 *             "path"="/admin/partner",
 *             "method"="GET",
 *              "normalization_context"={
 *                "groups"={"getPartner"}
 *              }
 *         },
 *     },
 * )
 * @Vich\Uploadable
 */
class Partner
{
    /**
     * @var UuidInterface
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="images", fileNameProperty="filepath")
     * @Assert\NotBlank(message="File can't be null")
     *
     */
    private $file;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getPartner"})
     */
    private $filepath;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Url can't be null")
     * @Groups({"getPartner"})
     */
    private $url;

    public function __construct() {
        $this->id = Uuid::uuid4();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFilepath()
    {
        return '/images/'.$this->filepath;
    }

    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }



}
