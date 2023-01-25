<?php


namespace Invertus\Printify\Model;


class PublishDetails
{

    /**
     * @var bool
     */
    private $title;

    /**
     * @var bool
     */
    private $variants;

    /**
     * @var bool
     */
    private $description;

    /**
     * @var bool
     */
    private $tags;

    /**
     * @var bool
     */
    private $images;

    /**
     * @return bool
     */
    public function isTitle()
    {
        return $this->title;
    }

    /**
     * @param bool $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isVariants()
    {
        return $this->variants;
    }

    /**
     * @param bool $variants
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
    }

    /**
     * @return bool
     */
    public function isDescription()
    {
        return $this->description;
    }

    /**
     * @param bool $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isTags()
    {
        return $this->tags;
    }

    /**
     * @param bool $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function isImages()
    {
        return $this->images;
    }

    /**
     * @param bool $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }
}
