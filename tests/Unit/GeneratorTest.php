<?php
/**
 * Gravatar Generator unit tests.
 *
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/gravatar
 * @copyright Copyright (c) 2015, MyBB Group
 * @license   http://www.mybb.com/licenses/bsd3 BSD-3
 * @link      http://www.mybb.com
 */

namespace MyBB\Gravatar\Test\Unit;

use MyBB\Gravatar\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testBasicEmail()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.png?s=80&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testBasicEmailSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);

        $generator = new Generator();
        $generator->setEmail($email);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.png?s=80&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testInvalidEmail()
    {
        $this->setExpectedException('InvalidArgumentException');

        $email = 'test';

        $generator = new Generator();
        $generator->setEmail($email);
    }

    public function testSetExtension()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $extension = 'jpg';

        $generator = new Generator(['secure' => false,]);
        $generator->setEmail($email);
        $generator->setExtension($extension);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.{$extension}?s=80&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetExtensionSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $extension = 'jpg';

        $generator = new Generator();
        $generator->setEmail($email);
        $generator->setExtension($extension);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.{$extension}?s=80&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetSize()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $size = 100;

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);
        $generator->setSize($size);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.png?s={$size}&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetSizeSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $size = 100;

        $generator = new Generator();
        $generator->setEmail($email);
        $generator->setSize($size);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.png?s={$size}&d=mm&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetDefault()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $default = 'retro';

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);
        $generator->setDefault($default);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.png?s=80&d={$default}&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetDefaultSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $default = 'retro';

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);
        $generator->setDefault($default);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.png?s=80&d={$default}&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testForceDefault()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $default = 'retro';

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);
        $generator->setDefault($default);
        $generator->setForceDefault(true);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.png?s=80&d={$default}&forcedefault=y&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testForceDefaultSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $default = 'retro';

        $generator = new Generator();
        $generator->setEmail($email);
        $generator->setDefault($default);
        $generator->setForceDefault(true);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.png?s=80&d={$default}&forcedefault=y&rating=g";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetRating()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $rating = 'pg';

        $generator = new Generator(['secure' => false]);
        $generator->setEmail($email);
        $generator->setRating($rating);

        $expected = "http://www.gravatar.com/avatar/{$emailHash}.png?s=80&d=mm&rating={$rating}";

        $this->assertEquals($expected, $generator->getGravatar());
    }

    public function testSetRatingSecure()
    {
        $email = 'test@email.com';
        $emailHash = md5($email);
        $rating = 'pg';

        $generator = new Generator();
        $generator->setEmail($email);
        $generator->setRating($rating);
        $generator->setSecure(true);

        $expected = "https://secure.gravatar.com/avatar/{$emailHash}.png?s=80&d=mm&rating={$rating}";

        $this->assertEquals($expected, $generator->getGravatar());
    }
}
