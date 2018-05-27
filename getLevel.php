<?PHP 

namespace pokemonapi;

class getLevel {
    // Gets the level of a trainer's pokemon
    protected $trainer;
    protected $pokemon; 

    public function __construct( $trainerName, $pokemonName )
    {
        $this->trainer = $trainerName;
        $this->pokemon = $pokemonName;
    }

    public function execute( $API )
    {
        $tConnection = null;
        if ( $API->getConnection( $tConnection ) )
        {
            try
            {
                $statement = $tConnection->prepare( "SELECT p.level FROM pokemon AS p JOIN owners AS o ON o.id = p.owner WHERE o.name = :owner AND p.name = :pokemon" );
                $statement->execute( ["owner"=>$this->trainer, "pokemon"=>$this->pokemon] );
                $statement->execute();
                $results = $statement->fetchAll( \PDO::FETCH_ASSOC );
                if ( !empty ( $results ) )
                {
                    $API->setTextResponse( $this->trainer . "'s " . $this->pokemon . " is level " . $results[0]["level"] );
                }
                else
                {
                    $API->setTextResponse( $this->trainer . " doesn't have a " . $this->pokemon . "." );
                }
            }
            catch ( \PDOException $e )
            {
                echo $e;
            }
        }
        else
        {
            // The connection failed
            $API->setTextResponse( "Database connection failure." );
        }
    }

}

?>