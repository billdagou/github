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
        if (!$request->getHeader('X-GitHub-Event')) {
            return FALSE;
        }

        if (!$request->getHeader('X-GitHub-Delivery')) {
            return FALSE;
        }

        if (($signature = $request->getHeader('X-Hub-Signature')[0])) {
            list($algorithm, $hash) = explode('=', $signature);

            if (hash_hmac($algorithm, $request->getBody()->getContents(), $secret) !== $hash) {
                return FALSE;
            }

            $request->getBody()->rewind();
        }

        return TRUE;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return array|NULL
     */
    public function parsePayload(ServerRequestInterface $request): ?array {
        switch ($request->getHeader('Content-Type')[0]) {
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