<?php

namespace Tests\Unit\Mail;

use App\Mail\MailTemplateParser;
use Handlebars\Handlebars;
use Mockery;
use Tests\TestCase;

class MailTemplateParserTest extends TestCase
{
    public function test_it_calls_the_handlebars_parser_with_correct_parameters()
    {
        $handlebarsMock = Mockery::mock(Handlebars::class);

        $handlebarsMock
            ->shouldReceive('render')
            ->once()
            ->with('Hello my name is {{ name }}', ['name' => 'John doe'])
            ->andReturn('parsed_template');

        $parser = new MailTemplateParser($handlebarsMock);
        $result = $parser->parse('Hello my name is {{ name }}', ['name' => 'John doe']);

        $this->assertEquals('parsed_template', $result);
    }
}
