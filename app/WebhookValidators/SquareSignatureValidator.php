<?php

namespace App\WebhookValidators;

use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Illuminate\Http\Request;
use Square\Utils\WebhooksHelper;

class SquareSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (app()->environment('local')) {
            return true;
        }
        return WebhooksHelper::verifySignature(
            requestBody: $request->getContent(),
            signatureHeader: $request->header('x-square-hmacsha256-signature'),
            signatureKey: $config->signingSecret,
            notificationUrl: config('app.url') . '/webhook/square', // Must match Square dashboard
        );
    }
}
