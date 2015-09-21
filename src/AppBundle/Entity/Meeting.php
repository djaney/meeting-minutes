<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Meeting
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Meeting
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="update_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="MeetingMinutes", mappedBy="meeting", cascade={"all"})
     **/
    private $minutes;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank
     */
    private $name = '';

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description = '';

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->minutes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Meeting
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Meeting
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add minute
     *
     * @param \AppBundle\Entity\MeetingMinutes $minute
     *
     * @return Meeting
     */
    public function addMinute(\AppBundle\Entity\MeetingMinutes $minute)
    {
        $this->minutes[] = $minute;

        return $this;
    }

    /**
     * Remove minute
     *
     * @param \AppBundle\Entity\MeetingMinutes $minute
     */
    public function removeMinute(\AppBundle\Entity\MeetingMinutes $minute)
    {
        $this->minutes->removeElement($minute);
    }

    /**
     * Get minutes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Meeting
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Meeting
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
