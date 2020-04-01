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
            file_put_contents('./webhook', 'No X-GitHub-Event'.LF, FILE_APPEND);

            return FALSE;
        }

        if (!$request->getHeader('X-GitHub-Delivery')) {
            file_put_contents('./webhook', 'No X-GitHub-Delivery'.LF, FILE_APPEND);

            return FALSE;
        }

        if (($signature = $request->getHeader('X-Hub-Signature'))) {
            list($algorithm, $hash) = explode('=', $signature);

            file_put_contents(
                './webhook',
                '$signature: '.$signature.LF.
                    '$algorithm: '.$algorithm.LF.
                    '$hash: '.$hash.LF,
                FILE_APPEND
            );

            if (hash_hmac($algorithm, $request->getBody()->getContents(), $secret) !== $hash) {
                file_put_contents(
                    './webhook',
                    'body: '.$request->getBody()->getContents(),
                    FILE_APPEND
                );

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
        switch ($request->getHeader(['Content-Type'])) {
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