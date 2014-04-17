<?php

namespace spec\DotZecker\Larafeed;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DotZecker\Larafeed\Feed');
    }
}
