<?php
/**
 * This file is part of the BEAR.Resource package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace FakeVendor\Sandbox\Resource\App;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;

class Blog extends ResourceObject
{
    private $repo = [
        11 => ['id' => 11, 'name' => 'Athos blog'],
        12 => ['id' => 12, 'name' => 'Aramis blog'],
        16 => ['id' => 16, 'name' => 'Porthos blog'],
        99 => ['id' => 19, 'name' => 'BEAR blog'],
    ];

    /**
     * @Link(rel="post", href="app://self/marshal/post?blog_id={id}", crawl="tree")
     */
    public function onGet($id)
    {
        $this->body = $this->repo[$id];

        return $this;
    }
}
