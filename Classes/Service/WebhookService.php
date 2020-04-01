<?php
namespace Dagou\Github\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\SingletonInterface;

class WebhookService implements SingletonInterface {
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $secret
     *
     * @return bool
     */
    public function securityVerification(ServerRequestInterface $request, string $secret): bool {
        if (!$request->getHeader('x-gitHub-event')) {
            return FALSE;
        }

        if (!$request->getHeader('x-gitHub-delivery')) {
            return FALSE;
        }

        if (($signature = $request->getHeader('x-hub-signature'))) {
            [$algorithm, $hash] = explode('=', $signature);

            if (hash_hmac($algorithm, $request->getBody()->getContents(), $secret) !== $hash) {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return array|NULL
     */
    public function parsePayload(ServerRequestInterface $request): ?array {
        switch ($request->getHeader(['content-type'])) {
            case 'application/json':
                $payload = $request->getBody()->getContents();
            break;
            case 'application/x-www-form-urlencoded':
                $payload = $request->getParsedBody()['payload'];
            break;
            default:
                return NULL;
        }

        return json_decode($payload, TRUE);
    }
}