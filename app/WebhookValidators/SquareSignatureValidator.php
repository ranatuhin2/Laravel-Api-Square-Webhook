<?php

namespace App\WebhookValidators;

use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Illuminate\Http\Request;

class SquareSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header('x-square-signature');
        $rawBody = $request->getContent();

        $webhookUrl = 'https://precious-mole-endless.ngrok-free.app/api/webhook/square';
        $computed = base64_encode(hash_hmac('sha1', $webhookUrl . $rawBody, $config->signingSecret, true));

        return hash_equals($computed, $signature);
    }
}
