<?PHP

namespace pokemonapi;
use PDO;

class baseAPI {
    protected $connection;
    protected $output;
    protected $responseObj;
    protected $URI;
    protected $input;

    function __construct()
    {
        $tempURI = null;
        $tempURIString = $_SERVER[ "REQUEST_URI" ];
        $tempURIString = ltrim( $tempURIString, '/' );
		if ( $tempURIString != "" )
		{
			$tempURI = explode( "/", $tempURIString );
        }
        $this->URI = $tempURI;

        $update_response = file_get_contents("php://input");
        $update = json_decode($update_response);
        $this->input = $update;
    }

    public function setTextResponse( $text )
    {
        $fulfillmentMessage = array( "text" => array( "text" => array( $text ) ) );
        $this->responseObj = array( "fulfillmentText"=> "This is a webhook response",
        "fulfillmentMessages" => array( $fulfillmentMessage ),
        "source" => "");
        http_response_code( 200 );
        echo json_encode( $this->responseObj );
    }

    public function getConnection( &$tConnection )
    {
        try
        {
            if ( $tConnection == null )
            {
                $tConnection = new PDO("mysql:host=localhost;dbname=pokemon", "root", "fh39423gh7");
                $tConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
        }
        catch ( PDOException $e )
        {
            return false;
        }
        return true;
    }
}

?>