<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *       "get",
 *       "put"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() == user"
 *        }
 *     },
 *     collectionOperations={
 *        "get"={
 *            "normalization_context"={
 *                "groups"={"get-comment"}
 *            }
 *        },
 *        "post"={
 *           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *         },
 *         "api_blog_posts_comments_get_subresource"={
 *            "normalization_context"={
 *                "groups"={"get-comment-with-author"}
 *            }
 *         }
 *     },
 *     normalizationContext={
 *         "groups"={"get-comment-with-author"}
 *     },
 *     denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */

//Subresources is not working only with normalization in it - need fix later
class Comment implements AuthoredEntityInterface, PublishedDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     * @Groups({"post", "get-comment-with-author", "get-blog_post-with-author"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-comment-with-author"})
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-comment-with-author"})
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post"})
     */
    private $blogPost;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
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


    public function getBlogPost(): BlogPost
    {
        return $this->blogPost;
    }


    public function setBlogPost(BlogPost $blogPost): self
    {
        $this->blogPost = $blogPost;

        return $this;
    }




}
