<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait GetsStreamedResponses
{
    public function getStreamedResponse(StreamedResponse $response): string
    {
        ob_start();
        $response->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
