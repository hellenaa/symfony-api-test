<?php
/**
 * Created by PhpStorm.
 * User: Macroscop
 * Date: 31.10.2019
 * Time: 10:49
 */

namespace App\DataFixtures;


use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;


    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'name' => 'Lena Karamian',
            'password' => 'secret1234'
        ],
        [
            'username' => 'graf',
            'email' => 'graf@blog.com',
            'name' => 'Graf Neil',
            'password' => 'secret1234'
        ],
        [
            'username' => 'sand',
            'email' => 'sand@blog.com',
            'name' => 'Sand mik',
            'password' => 'secret1234'
        ],
        [
            'username' => 'bery',
            'email' => 'bery@blog.com',
            'name' => 'Beri knot',
            'password' => 'secret1234'
        ],
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {

        for ($i = 0; $i<100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTimeThisYear);
            $blogPost->setContent($this->faker->realText());

            $authorReference = $this->getRandomUserReference();

            $blogPost->setAuthor($authorReference);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference('blog_post_'.$i, $blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {

        for ($i = 0; $i<100; $i++) {
            for($j = 0; $j<rand(1,10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);

                $authorReference = $this->getRandomUserReference();

                $comment->setAuthor($authorReference);
                $comment->setBlogPost($this->getReference("blog_post_".$i));

                $manager->persist($comment);
            }
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {

        foreach (self::USERS as $userfixture) {

            $user = new User();
            $user->setUsername($userfixture['username']);
            $user->setEmail($userfixture['email']);
            $user->setName($userfixture['name']);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $userfixture['password']
            ));

            $this->setReference('user_'.$userfixture['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();

    }


    protected function getRandomUserReference(): User
    {
        return $this->getReference('user_'.self::USERS[rand(0, 3)]['username']);
    }

}