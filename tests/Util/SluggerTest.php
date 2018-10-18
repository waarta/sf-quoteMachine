<?php

namespace App\Test\Util;

use App\Util\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugify()
    {
        $slug = new Slugger();
        $res1 = $slug->slugify("kaamelott");
        $res2 = $slug->slugify(" Kaamelott");
        $res3 = $slug->slugify("kaamelott-livre-3");
        $res4 = $slug->slugify("Kaamelott - livre 3");

        $this->assertEquals("kaamelott", $res1);
        $this->assertEquals("kaamelott", $res2);
        $this->assertEquals("kaamelott-livre-3", $res3);
        $this->assertEquals("kaamelott---livre-3", $res4);
    }
}
