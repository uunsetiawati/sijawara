<?php
/**
 * KrmPesan PHP SDK.
 *
 * @version     1.2.0
 *
 * @see         https://github.com/KrmPesan/SDK-PHP
 *
 * @author      KrmPesan <support@krmpesan.com>
 * @copyright   2020 KrmPesan
 */

namespace KrmPesan;

use Exception;

/**
 * KrmPesan Client Class For Handle REST API Request.
 *
 * @see https://docs.krmpesan.com/
 */
class Client
{
    /**
     * Default Curl Timeout.
     *
     * @var int
     *
     * @see https://www.php.net/manual/en/function.curl-setopt
     */
    protected $timeout;

    /**
     * Default API Url.
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * API Token.
     *
     * @var string
     */
    protected $token;

    /**
     * Region Available.
     *
     * @var array
     */
    protected $regionPanel = [
        '01'    => 'https://region01.krmpesan.com',
        '02'    => 'https://region02.krmpesan.com',
    ];

    /**
     * Custom Request Header.
     *
     * @var array
     */
    protected $customHeader;

    /**
     * Construct Function.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        // Select Region
        if (isset($data['region']) and !empty($data['region'])) {
            if (isset($this->regionPanel[$data['region']])) {
                $this->apiUrl = $this->regionPanel[$data['region']];
            } else {
                $this->apiUrl = $data['region'];
            }
        } else {
            throw new Exception('Region Not Found');
        }

        // Custom Set Timeout
        $this->timeout = isset($data['timeout']) and !empty($data['timeout']) ? $data['timeout'] : 30;

        // Set Token
        if (!isset($data['token']) or empty($data['token'])) {
            throw new Exception('Token is required.');
        } else {
            $this->token = $data['token'];
        }

        // Set Custom Header
        $this->customHeader = isset($data['headers']) and !empty($data['headers']) ? $data['headers'] : null;
    }

    /**
     * Curl Post or Get Function.
     *
     * @param string $type
     * @param string $url
     * @param array  $form
     *
     * @return void
     */
    private function action($type, $url, $form = null)
    {
        // setup url
        $buildUrl = $this->apiUrl.'/'.$url;

        // set default header
        $headers = [];
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer '.$this->token;

        // use custom header if not null
        if ($this->customHeader) {
            $headers = $this->customHeader;
        }

        if (
            isset($form['image']) xor
            isset($form['document'])
        ) {
            // update header type
            $headers[] = 'Content-Type: multipart/form-data';

            // update form data
            $fileData = $form['image'] ?? $form['document'];

            // parse file and get file information
            // https://www.php.net/manual/en/function.realpath
            $file = realpath($fileData);
            // https://www.php.net/manual/en/function.basename
            $filename = basename($file);
            // https://www.php.net/manual/en/function.mime-content-type
            $filemime = mime_content_type($file);

            if (isset($form['image'])) {
                $form['image'] = curl_file_create($file, $filemime, $filename);
            } else {
                $form['document'] = curl_file_create($file, $filemime, $filename);
            }
        } else {
            $headers[] = 'Content-Type: application/json';
        }

        // build curl instance
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $buildUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // check action type
        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form);
        } elseif ($type == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form);
        } elseif ($type == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        // running curl
        $result = curl_exec($ch);

        // throw error
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        // stop connection
        curl_close($ch);

        // return result request
        return $result;
    }

    /**
     * Device Information.
     *
     * @return void
     */
    public function deviceInfo()
    {
        return $this->action('GET', 'api/v2/device');
    }

    /**
     * Restart Device Connection.
     *
     * @return void
     */
    public function deviceRestart()
    {
        return $this->action('GET', 'api/v2/device/restart');
    }

    /**
     * Update Device Data.
     *
     * @param array $form Form Update Device
     *
     * @return void
     */
    public function deviceUpdate(array $form)
    {
        return $this->action('PUT', 'api/v2/device', json_encode($form));
    }

    /**
     * Get All Message.
     *
     * @param int $page
     *
     * @return void
     */
    public function getMessage($page = null)
    {
        $url = 'api/v2/message';

        if ($page) {
            $url = 'api/v2/message?page='.$page;
        }

        return $this->action('GET', $url);
    }

    /**
     * Get All Message Inbox.
     *
     * @param int $page
     *
     * @return void
     */
    public function getMessageInbox($page = null)
    {
        $url = 'api/v2/message/inbox';

        if ($page) {
            $url = 'api/v2/message/inbox?page='.$page;
        }

        return $this->action('GET', $url);
    }

    /**
     * Get All Message Outbox.
     *
     * @param int $page
     *
     * @return void
     */
    public function getMessageOutbox($page = null)
    {
        $url = 'api/v2/message/outbox';

        if ($page) {
            $url = 'api/v2/message/outbox?page='.$page;
        }

        return $this->action('GET', $url);
    }

    /**
     * Get All Message Forward.
     *
     * @param int $page
     *
     * @return void
     */
    public function getMessageForward($page = null)
    {
        $url = 'api/v2/message/forward';

        if ($page) {
            $url = 'api/v2/message/forward?page='.$page;
        }

        return $this->action('GET', $url);
    }

    /**
     * Get Message by ID.
     *
     * @param string $uuid
     *
     * @return void
     */
    public function getMessageId($uuid)
    {
        return $this->action('GET', 'api/v2/message/'.$uuid);
    }

    /**
     * Send Message Text.
     *
     * @param string|int $to
     * @param string     $message
     *
     * @return void
     */
    public function sendMessageText($to, $message)
    {
        // build form
        $form = json_encode([
            'phone'     => $to,
            'message'   => $message,
        ]);

        return $this->action('POST', 'api/v2/message/send-text', $form);
    }

    /**
     * Send Message Image.
     *
     * @param string|int $to
     * @param string     $image
     * @param string     $caption
     *
     * @return void
     */
    public function sendMessageImage($to, $image, $caption = null)
    {
        // build form
        $form = [
            'phone'     => $to,
            'image'     => $image,
            'caption'   => $caption,
        ];

        return $this->action('POST', 'api/v2/message/send-image', $form);
    }

    /**
     * Send Message Document.
     *
     * @param string|int $to
     * @param string     $document
     *
     * @return void
     */
    public function sendMessageDocument($to, $document)
    {
        // build form
        $form = [
            'phone'     => $to,
            'document'  => $document,
        ];

        return $this->action('POST', 'api/v2/message/send-document', $form);
    }

    /**
     * Send Message Bulk by Number.
     *
     * @param array  $to
     * @param string $message
     *
     * @return void
     */
    public function sendBulkNumber(array $to, $message)
    {
        // build form
        $form = json_encode([
            'phone'    => $to,
            'message'  => $message,
        ]);

        return $this->action('POST', 'api/v2/message/send-bulk', $form);
    }

    /**
     * Send Message Bulk by Group ID.
     *
     * @param string $groupId
     * @param string $message
     *
     * @return void
     */
    public function sendBulkGroup($groupId, $message)
    {
        // build form
        $form = json_encode([
            'groupid'  => $groupId,
            'message'  => $message,
        ]);

        return $this->action('POST', 'api/v2/message/send-bulk-group', $form);
    }

    /**
     * Send Message Text to Group.
     *
     * @param int    $groupId
     * @param string $message
     *
     * @return void
     */
    public function sendMessageTextGroup($groupId, $message)
    {
        // build form
        $form = json_encode([
            'groupid'  => $groupId,
            'message'  => $message,
        ]);

        return $this->action('POST', 'api/v2/message/send-group-text', $form);
    }

    /**
     * Send Message Image To Group.
     *
     * @param int    $groupId
     * @param string $image
     * @param string $caption
     *
     * @return void
     */
    public function sendMessageImageGroup($groupId, $image, $caption = null)
    {
        // build form
        $form = [
            'groupid'  => $groupId,
            'image'    => $image,
            'caption'  => $caption,
        ];

        return $this->action('POST', 'api/v2/message/send-group-image', $form);
    }

    /**
     * Send Message Image To Group.
     *
     * @param int    $groupId
     * @param string $image
     * @param string $caption
     *
     * @return void
     */
    public function sendMessageDocumentGroup($groupId, $image, $caption = null)
    {
        // build form
        $form = [
            'groupid'  => $groupId,
            'image'    => $image,
            'caption'  => $caption,
        ];

        return $this->action('POST', 'api/v2/message/send-document-image', $form);
    }
}
