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
    public function verifySecurity(ServerRequestInterface $request, string $secret): bool {
        if (($signature = $request->getHeader('x-hub-signature-256')[0])) {
            [$algorithm, $hash] = explode('=', $signature);

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
     * @return array|null
     */
    public function parsePayload(ServerRequestInterface $request): ?array {
        switch ($request->getHeader('content-type')[0]) {
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