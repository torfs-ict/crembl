<?php

namespace Crembl;

use Crembl\Config\TaskConfig;
use Crembl\Exception\Exception;
use Crembl\Exception\Info as ErrorInfo;
use Crembl\Task\Info;
use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;

/**
 * Crembl API client.
 */
class Client {
    private $guzzle;
    private $jms;
    private $userKey;
    private function deserialize(string $json, string $class) {
        if (empty($json)) $json = '{}';
        return $this->jms->deserialize($json, $class, 'json');
    }
    private function exception(Response $response) {
        $info = $this->deserialize($response->getBody()->getContents(), ErrorInfo::class);
        return new Exception($info);
    }

    /**
     * Client constructor.
     *
     * @param string $userKey The user API key, used to identify the user.
     */
    public function __construct(string $userKey) {
        AnnotationRegistry::registerLoader('class_exists');
        $this->jms = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
        $this->guzzle = new Guzzle([
            'base_uri' => 'https://app.crembl.com/'
        ]);
        $this->userKey = $userKey;
    }

    /**
     * Creates a new task.
     *
     * @param TaskConfig $task The task configuration.
     * @throws RequestException
     * @throws Exception
     * @return string The task id.
     */
    public function createTask(TaskConfig $task): string {
        try {
            $post = array_merge($task->__toArray(), ['userKey' => $this->userKey]);
            $response = $this->guzzle->post('/rest/task-create', ['form_params' => $post]);
            $body = $response->getBody()->getContents();
            if (empty($body)) $body = '{}';
            $json = \json_decode($body, true);
            if (array_key_exists('apiRequestKey', $json)) {
                return $json['apiRequestKey'];
            } else {
                $error = new ErrorInfo();
                $error->reason = 'No id was returned for the task.';
                $error->type = 'client-exception';
                throw new Exception($error);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw $this->exception($e->getResponse());
            } else {
                throw $e;
            }
        }
    }

    /**
     * Uploads a file to a previously created task.
     *
     * @param string $id The task id.
     * @param string $path The filesystem path to the file.
     * @param string|null $filename The filename to set, will be inferred if omitted.
     * @return bool Returns TRUE on success, FALSE on failure.
     */
    public function uploadFile(string $id, string $path, string $filename = null): bool {
        if (!file_exists($path)) throw new \InvalidArgumentException(sprintf('The file "%s" could not be found.', $path));
        if (empty($filename)) $filename = basename($path);
        return $this->uploadFileFromString($id, $filename, file_get_contents($path));
    }

    /**
     * Uploads a file (from a string) to a previously created task.
     *
     * @param string $id The task id.
     * @param string $filename The filename to set.
     * @param string $contents The string contents of the file.
     * @throws Exception
     * @throws RequestException
     * @return bool Returns TRUE on success, FALSE on failure.
     */
    public function uploadFileFromString(string $id, string $filename, string $contents): bool {
        try {
            $response = $this->guzzle->post('/apirequestfileupload/' . $id, ['multipart' => [
                ['name' => 'file', 'filename' => $filename, 'contents' => $contents]
            ]]);
            return ($response->getStatusCode() == 200);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw $this->exception($e->getResponse());
            } else {
                throw $e;
            }
        }
    }

    /**
     * Gets all information about a previously created task.
     *
     * @param string $id The task id.
     * @return Info
     * @throws Exception
     * @throws RequestException
     */
    public function getTaskInfo(string $id): Info {
        try {
            $response = $this->guzzle->get('/rest/api-request', ['query' => ['apiRequestKey' => $id]]);
            return $this->deserialize($response->getBody()->getContents(), Info::class);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw $this->exception($e->getResponse());
            } else {
                throw $e;
            }
        }
    }
}