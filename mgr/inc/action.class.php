<?php	if(!defined('IN_SITE')) exit("Request Error!");

/**
 * 操作执行类
 * 说明:
 * 调用这个类前,请先确保外部已设定需要用到的变量
 *
 * $GLOBALS['action'];
 * $GLOBALS['dosql'];
 * $GLOBALS['tbname'];
 * $GLOBALS['gourl'];
*/


$do = new ActClass($action);

class ActClass
{

	public $action;
	public $dosql;
	public $tbname;
	public $gourl;
	public $id;
	public $checkid;
	public $parentid;
	public $parentstr;
	public $orderid;
	public $checkinfo;


    function __construct($isact='')
    {
		if($isact)
		{
			$this->Init();
		}
    }

    function ActClass($isact='')
    {
		$this->__construct($isact='');
    }
	
	function Init()
    {
		$this->action    = $GLOBALS['action'];
		$this->dosql     = $GLOBALS['dosql'];
        $this->tbname    = $GLOBALS['tbname'];
		$this->gourl     = $GLOBALS['gourl'];
        $this->id        = isset($GLOBALS['id'])        ? $GLOBALS['id']        : '';
        $this->checkid   = isset($GLOBALS['checkid'])   ? $GLOBALS['checkid']   : '';
        $this->parentid  = isset($GLOBALS['parentid'])  ? $GLOBALS['parentid']  : '';
		$this->parentstr = isset($GLOBALS['parentstr']) ? $GLOBALS['parentstr'] : '';
		$this->orderid   = isset($GLOBALS['orderid'])   ? $GLOBALS['orderid']   : '';
		$this->checkinfo = isset($GLOBALS['checkinfo']) ? $GLOBALS['checkinfo'] : '';

		$this->Execfunc();
    }

	//执行相应操作
	function Execfunc()
	{
		switch($this->action)
		{
			case 'del':
				$this->Del();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'delall':
				$this->DelAll();
				header('location:'.$this->gourl);
				exit();
			break;
			
			case 'del2':
				$this->DelNone();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'delall2':
				$this->DelAllNone();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'up':
				$this->UpOrderID();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'down':
				$this->UpOrderID();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'uporder':
				$this->UpAllOrder();
				header('location:'.$this->gourl);
				exit();
			break;

			case 'check':
				$this->UpCheck();
				header('location:'.$this->gourl);
				exit();
			break;

			default:
			break;
		}
	}

	//删除单条记录
	function Del()
	{
		$this->dosql->ExecNoneQuery("DELETE FROM `$this->tbname` WHERE (id=$this->id Or parentstr Like '%,$this->id,%')");
	}

	//删除全选记录
	function DelAll()
	{
		foreach($this->checkid as $k => $v)
		{
			$this->dosql->ExecNoneQuery("DELETE FROM `$this->tbname` WHERE (id=$v Or parentstr Like '%,$v,%')");
		}
	}

	//删除单条记录(不包含下级)
	function DelNone()
	{
		$this->dosql->ExecNoneQuery("DELETE FROM `$this->tbname` WHERE id=$this->id");
	}

	//删除全选记录(不包含下级)
	function DelAllNone()
	{
		foreach($this->checkid as $k => $v)
		{
			$this->dosql->ExecNoneQuery("DELETE FROM `$this->tbname` WHERE id=$v");
		}
	}

	//更新单条排序
	function UpOrderID()
	{
		if($this->action == 'up' and $this->parentid == '')
		{
			$sql = "SELECT id,orderid FROM `$this->tbname` WHERE orderid<$this->orderid ORDER BY orderid DESC";
		}

		else if($this->action == 'up' and $this->parentid != '')
		{
			$sql = "SELECT id,orderid FROM `$this->tbname` WHERE parentid=$this->parentid AND orderid<$this->orderid ORDER BY orderid DESC";
		}

		else if($this->action == 'down' and $this->parentid == '')
		{
			$sql = "SELECT id,orderid FROM `$this->tbname` WHERE orderid>$this->orderid ORDER BY orderid ASC";
		}

		if($this->action == 'down' and $this->parentid != '')
		{
			$sql = "SELECT id,orderid FROM `$this->tbname` WHERE parentid=$this->parentid AND orderid>$this->orderid ORDER BY orderid ASC";
		}

		$row = $this->dosql->GetOne($sql);

		if($row['orderid']!='' and $row['id']!='')
		{
			$newid = $row['id'];
			$neworderid = $row['orderid'];
			$this->dosql->ExecNoneQuery("UPDATE `$this->tbname` SET orderid=$neworderid WHERE id=$this->id");
			$this->dosql->ExecNoneQuery("UPDATE `$this->tbname` SET orderid=$this->orderid WHERE id=$newid");
		}
	}

	//更新所有排序
	function UpAllOrder()
	{
		foreach($this->id as $k => $v)
		{
			$this->dosql->ExecNoneQuery("UPDATE `$this->tbname` SET orderid=".$this->orderid[$k]." WHERE id=$v");
		}
	}

	//更新审核状态
	function UpCheck()
	{
		if($this->checkinfo == 'true')
		{
			$sql = "UPDATE `$this->tbname` SET checkinfo='false' WHERE id=$this->id";
		}
		else if($this->checkinfo == 'false')
		{
			$sql = "UPDATE `$this->tbname` SET checkinfo='true' WHERE id=$this->id";
		}

		$this->dosql->ExecNoneQuery($sql);
	}

	//获取parentstr
	function GetParentStr()
	{
		if($this->parentid == 0)
		{
			$this->parentstr = '0,';
		}
		else
		{
			$row = $this->dosql->GetOne("SELECT parentstr FROM `$this->tbname` WHERE id=$this->parentid");
			$this->parentstr = $row['parentstr'].$this->parentid.',';
		}
		return $this->parentstr;
	}

	/*
	 * 函数说明：更新parentstr字段
	 *
	 * $id          int     为类型id
	 * $childtbname string  为涉及到的子表
	 * $field       string  为子表中str字段代表
	 * $field2      string  为子表中的cid字段代表
	*/
	function UpParentStr($id='',$childtbname='',$field='',$field2='',$pstr='')
	{

		//获取当前parentstr
		if($pstr == '')
		{
			$parstr = $this->parentstr.$id.',';
		}
		else
		{
			$parstr = $pstr.$id.',';
		}


		//获取当前ID下所有子ID
		$this->dosql->Execute("SELECT id FROM `$this->tbname` WHERE parentid=$id",$id);
		while($row = $this->dosql->GetArray($id))
		{

			//更新类别表parentstr
			$this->dosql->ExecNoneQuery("UPDATE `$this->tbname` SET parentstr='".$parstr."' WHERE id=".$row['id']);


			//更新信息表parentstr
			//如果包含多个子信息表,则循环更新子信息表
			if(isset($childtbname))
			{
				if(is_array($childtbname))
				{
					foreach($childtbname as $k=>$v)
					{
						$this->dosql->ExecNoneQuery("UPDATE `$v` SET $field='".$parstr."' WHERE $field2=".$row['id']);
					}
				}
				else
				{
					$this->dosql->ExecNoneQuery("UPDATE `$childtbname` SET $field='".$parstr."' WHERE $field2=".$row['id']);
				}
			}


			//传递下级参数,继续更新
			$this->UpParentStr($row['id'], $childtbname, $field, $field2, $parstr);
		}
	}
}
?>