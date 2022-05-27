<?php
class MysqlAdapter
{
    protected $config=array();
    protected $link;
    public $result;

    //constructor
    public function __construct(array $config)
    {
        if(count($config) !== 4)
        {
            throw new InvalidArgumentException(' invalid number of connection parameters ');
        }
        $this->config = $config;
    }

    // connect to DB
    function connect()
    {
        if($this->link === null)
        {
            list($host,$user,$password,$db)=$this->config;
            $this->link=@mysqli_connect($host,$user,$password,$db);
            if(mysqli_connect_errno())
            {
                throw new InvalidArgumentException(' error connection : '.mysqli_connect_error());
            }
            unset($host,$user,$password,$db);
        }
        return $this->link;
    }

    // execute query 
    function query($query)
    {
        if(empty($query) || !is_string($query))
        {
            throw new InvalidArgumentException('invalid query');
        }
        // lazy connect to mysql
        $this->connect();
        if(!($this->result=mysqli_query($this->link,$query)))
        {
            throw new InvalidArgumentException('error executing query').mysqli_error($this->link);
        }
        return $this->result;
    }

    // perform select 
    public function select($table,$where='',$fields='*',$limit=null,$offset=null,$order='')
    {
        $query = 'select '.$fields.' from '.$table.
        (($where)? ' where '.$where :'').
        (($limit)? ' limit '.$limit : '').
        (($offset && $limit)? ' offset '.$offset :'').
        (($order)? ' order by '.$order :'');

        $this->query($query);
    }
    // insert
    public function insert ($table,array $data)
    {
        $fields= implode(',',array_keys($data));
        $values= implode(',',array_map(array($this,'quoteValue'),array_values($data)));
        $query="insert into ".$table." ( ".$fields." ) values ( ".$values." ) " ;
        $this->query($query);
    } 

    // perform update 
    public function update($table,array $data,$where='')
    {
        $set=array();
        foreach($data as $field => $value)
        {
            $set[] = $field."=".$this->quoteValue($value);
        }
        $set = implode(",",$set);
        $query="update ".$table." set ".$set.
        (($where)?" where ".$where : '');
        $this->query($query);
        
    }
     
    //delete 
    public function delete ($table,$where='')
    {
        $query="delete from ".$table.
        (($where)?" where ".$where :'');
        $this->query($query);
    }

    //fetch data 
    public function fetch()
    {
        if($this->result !== null)
        {
            if(($row=mysqli_fetch_array($this->result,MYSQLI_ASSOC))==false)
            {
                mysqli_free_result($this->result);
            }
            return $row;
        }
        return false;

    }

    public function fetchAll()
    {
        if($this->result !== null)
        {
            if(($all=mysqli_fetch_all($this->result,MYSQLI_ASSOC))==true)
            {
                mysqli_free_result($this->result);
            }
            return $all;
        }
        return false ;

    }


    // get the last insert id 
    public function getInsertedId()
    {
        return $this->link !==null ? mysqli_insert_id($this->link) : null;
    }

    // get the number of rows returned by the current result set 
    public function countRows()
    {
        return $this->link !==null ? mysqli_num_rows($this->link) : 0;   
    }

    public function affectedRows()
    {
        return $this->link !==null ? mysqli_affected_rows($this->link) : 0;
    }
    // filter string 
    function quoteValue($value)
    {
        $this->connect();
        if($value===null)
        {
            $value='NULL';
        }
        else if(!is_numeric($value))
        {
            $value = "'".mysqli_real_escape_string($this->link,$value)."'";
        }
        return $value;
    }
    //disconnect 
    function disconnect()
    {
        if($this->link === null)
        {
            return false ;
        }
        mysqli_close($this->link);
        $this->link = null;
        return true;
    }

    //destruct
    public function __destruct()
    {
        $this->disconnect();
    }

}

?>