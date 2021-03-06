<?php

namespace App\Http\Controllers\Api\Assets;

use App\Transformers\Users\UserTransformer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Entities\Assets\Asset;
use Dingo\Api\Routing\Helpers;
use App\Events\AssetWasCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\BodyTooLargeException;
use GuzzleHttp\Exception\TransferException;
use App\Transformers\Assets\AssetTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProfileImageController.
 */
class ProfileImageController extends Controller
{
    use Helpers;

    /**
     * @var array
     */
    protected $validMimes = [
        'image/jpeg' => [
            'type' => 'image',
            'extension' => 'jpeg',
        ],
        'image/jpg' => [
            'type' => 'image',
            'extension' => 'jpg',
        ],
        'image/png' => [
            'type' => 'image',
            'extension' => 'png',
        ],
//        'text/plain' => [
//            'type' => 'text',
//            'extension' => 'txt',
//        ],
//        'application/pdf' => [
//            'type' => 'pdf',
//            'extension' => 'pdf',
//        ],

    ];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \App\Entities\Assets\Asset
     */
    protected $model;

    /**
     * UploadFileController constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @param \App\Entities\Assets\Asset $model
     */
    public function __construct(Client $client, Asset $model)
    {
        $this->client = $client;
        $this->model = $model;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        if ($request->isJson()) {
            $asset = $this->uploadFromUrl([
                'url' => $request->get('url'),
                'user' => $request->user(),
            ]);
        } else {
            $content = $request->post('avatar');
            $body = ! (base64_decode($content)) ? $content : base64_decode($content);
            $asset = $this->uploadFromDirectFile([
                'mime' => $request->file('avatar')->getMimeType(),
                'content' => $body,
                'Content-Length' => $request->file('avatar')->getClientSize(),
                'user' => $request->user(),
            ]);
        }

//        event(new AssetWasCreated($asset));
        return $this->response->item($asset, new UserTransformer())->setStatusCode(201);
//        return $this->response->item($asset, new AssetTransformer())->setStatusCode(201);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function uploadFromDirectFile($attributes = [])
    {
        $this->validateMime($attributes['mime']);
        $this->validateBodySize($attributes['Content-Length'], $attributes['content']);
        $path = $this->storeInFileSystem($attributes);

        return $this->storeInDatabase($attributes, $path);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function uploadFromUrl($attributes = [])
    {
        $response = $this->callFileUrl($attributes['url']);
        $attributes['mime'] = $response->getHeader('content-type')[0];
        $this->validateMime($attributes['mime']);
        $attributes['content'] = $response->getBody();
        $path = $this->storeInFileSystem($attributes);

        return $this->storeInDatabase($attributes, $path);
    }

    /**
     * @param array $attributes
     * @param $path
     * @return mixed
     */
    protected function storeInDatabase(array $attributes, $path)
    {
//        $file = $this->model->create([
//            'type' => $this->validMimes[$attributes['mime']]['type'],
//            'path' => $path,
//            'mime' => $attributes['mime'],
//            'user_id' => ! empty($attributes['user']) ? $attributes['user']->id : null,
//        ]);
        $user = Auth::user();
        $user->avatar = $path;
        $user->save();
        return $user->fresh();
    }

    /**
     * @param array $attributes
     * @return string
     */
    protected function storeInFileSystem(array $attributes)
    {
        $path = request()->file('avatar')->store('avatars', 'public');

//        $path = md5(str_random(16).date('U')).'.'.$this->validMimes[$attributes['mime']]['extension'];
//        Storage::put($path, $attributes['content']);

        return $path;
    }

    /**
     * @param $url
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function callFileUrl($url)
    {
        try {
            $response = $this->client->get($url);
            if ($response->getStatusCode() != 200) {
                throw new StoreResourceFailedException('Validation Error', [
                    'url' => 'The url seems unreachable',
                ]);
            }

            return $response;
        } catch (TransferException $e) {
            throw new StoreResourceFailedException('Validation Error', [
                'url' => 'The url seems to be unreachable: '.$e->getCode(),
            ]);
        }
    }

    /**
     * @param $mime
     */
    protected function validateMime($mime)
    {
        if (! array_key_exists($mime, $this->validMimes)) {
            throw new StoreResourceFailedException('Validation Error', [
                'Content-Type' => 'The Content Type sent is not valid',
            ]);
        }
    }

    /**
     * @param $contentLength
     * @param $content
     * @throws \App\Exceptions\BodyTooLargeException
     */
    protected function validateBodySize($contentLength, $content)
    {
        if ($contentLength > config('files.maxsize', 10000000)) {
            throw new BodyTooLargeException();
        }
        if (mb_strlen($content) > config('files.maxsize', 10000000)) {
            throw new BodyTooLargeException();
        }
    }
}
