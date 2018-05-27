<?PHP

namespace pokemonapi;

require_once( 'pokeapi.php' );
require_once( 'getLevel.php' );

class PokemonBot extends baseAPI 
{
    public function execute()
    {
        switch ( $this->input->queryResult->action )
        {
            case "getlevel":
                $trainer = $this->input->queryResult->parameters->Owner;
                $pokemon = $this->input->queryResult->parameters->Pokemon;
                ( new getLevel( $trainer, $pokemon ))->execute( $this );
                break;
            default:
                http_response_code( 400 );
                break;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'OPTIONS')
{
    header('Access-Control-Allow: POST, GET, OPTIONS');
    http_response_code(204);
} 
else if ($_SERVER["REQUEST_METHOD"] == 'POST')
{
    ( new PokemonBot() )->execute();
}
else 
{
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    http_response_code(405);
}
?>