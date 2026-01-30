<?php

use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

it('can load the chatgpt domain suggestion page', function () {
    $response = $this->get(route('chatgpt.index'));

    $response->assertStatus(200);
    $response->assertViewIs('chatgpt');
});

it('can get domain name suggestions from chatgpt', function () {
    // Mock the OpenAI facade
    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [
                [
                    'message' => [
                        'content' => "1. testdomain1.com\n2. testdomain2.com\n3. testdomain3.com\n4. testdomain4.com\n5. testdomain5.com",
                    ],
                ],
            ],
        ]),
    ]);

    $response = $this->post(route('chatgpt.getResponse'), [
        'title' => 'Real Estate',
    ]);

    $response->assertStatus(200);
    $response->assertViewIs('chatgpt');
    $response->assertSee('testdomain1.com');
    $response->assertSee('testdomain5.com');
});

it('does not call openai if title is missing', function () {
    OpenAI::fake();

    $response = $this->post(route('chatgpt.getResponse'), [
        'title' => '',
    ]);

    $response->assertStatus(200);
    $response->assertViewIs('chatgpt');
    
    // Ensure OpenAI was NOT called
    OpenAI::assertNothingSent();
});
