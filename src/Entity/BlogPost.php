<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 * @ApiResource(
 *     itemOperations={
 *       "get"={
 *           "normalization_context"={
 *              "groups"={"get-blog_post-with-author"}
 *           }
 *       },
 *       "put"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() == user"
 *        }
 *     },
 *     collectionOperations={
 *        "get",
 *        "post"={
 *           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *         }
 *     },
 *     denormalizationContext={
 *        "groups"={"get-blogPost"}
 *     }
 * )
 */
class BlogPost implements AuthoredEntityInterface, PublishedDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     * @Groups({"get-blogPost","get-blog_post-with-author"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-blog_post-with-author"})
     */
    private $published;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=20)
     * @Groups({"get-blogPost", "get-blog_post-with-author"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"get-blogPost", "get-blog_post-with-author"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-blog_post-with-author"})
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="blogPost")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     * @Groups({"get-blog_post-with-author"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author): AuthoredEntityInterface
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */

}
