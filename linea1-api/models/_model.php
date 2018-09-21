<?php namespace Models;

use Inc\Auth;
use Libs\Pixie\QB;

abstract class _model
{
    const ID = 'id';
    const DATE_CREATED = 'date_created';
    const DATE_UPDATED = 'date_updated';
    const DATE_DELETED = 'date_deleted';
    const STATE = 'state';

    const ORDER_BY = null;

    const _STATE_DELETED = 0;
    const _STATE_ENABLED = 1;

    protected $table = null;

    protected $hidden = [];

    protected $datas = []; // Datas para agregar o insertar

    public function __construct()
    {
        // Asignar tabla si no fue asignada manual
        if (is_null($this->table)) {
            $this->table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', real_class(static::class))) . 's';
        }
    }

    /**
     * @param array $columns
     * @return static[]
     */
    public static function all($columns = ['*'])
    {
        $ins = new static;
        $qb = $ins->QB()
            ->select(is_array($columns) ? $columns : func_get_args())
            ->asObject(static::class);
        if (!is_null(static::STATE)) {
            $qb = $qb->where($ins->table . '.' . static::STATE, '!=', static::_STATE_DELETED);
        }
        if (!is_null(static::ORDER_BY)) {
            $qb = $qb->orderBy($ins->table . '.' . static::ORDER_BY);
        }
        return $qb->get();
    }

    /**
     * @param string $col
     * @param mixed $val
     * @return static
     */
    public static function find($col, $val = null)
    {
        $new = (new static);
        $builder = $new->QB();
        $builder->asObject(static::class);
        if (is_null($val)) {
            $builder->where(static::ID, '=', $col);
        } else {
            $builder->where($col, '=', $val);
        }
        $item = $builder->first();
        if ($item) {
            if (!empty($new->hidden)) {
                foreach ($new->hidden as $attr) {
                    $item->$attr = '';
                }
            }
            return $item;
        } else {
            return $new;
        }
    }

    /**
     * @param $key
     * @param null $operator
     * @param null $value
     * @return QB
     */
    public static function where($key, $operator = null, $value = null, $veryFlat = false)
    {
        $ins = new static;
        $qb = $ins->QB()->where($key, $operator, $value);
        $qb->asObject(static::class);
        if (!$veryFlat) {
            if (!is_null(static::STATE) && $key != static::STATE) {
                $qb->where($ins->table . '.' . static::STATE, '!=', static::_STATE_DELETED);
            }
            if (!is_null(static::ORDER_BY)) {
                $qb->orderBy($ins->table . '.' . static::ORDER_BY);
            }
        }
        return $qb;
    }

    /**
     * @return QB
     */
    public static function QBuilder()
    {
        return (new static)->QB();
    }

    public static function insert($datas)
    {
        return (new static)->create($datas);
    }

    /**
     * @param string $k
     * @param mixed $v
     * @return static
     */
    public function data($k, $v)
    {
        $this->datas[$k] = $v;
        $this->$k = $v;
        return $this;
    }

    /**
     * @param array $datas
     * @return static
     */
    public function datas($datas = null)
    {
        if (is_array($datas)) {
            foreach ($datas as $k => $v) {
                $this->data($k, $v);
            }
        }
        return $this;
    }

    private function flush()
    {
        $this->datas = [];
    }

    /**
     * @param array $datas
     * @return bool
     */
    public function update($datas = null)
    {
        if ($this->exist()) {
            $this->datas($datas);

            if (!empty($this->datas)) {
                if (static::DATE_UPDATED) {
                    $this->data(static::DATE_UPDATED, QB::raw('NOW()'));
                }
                return $this->QB()
                    ->where(static::ID, '=', $this->getID())
                    ->update($this->datas);
            }
        }
        return false;
    }

    /**
     * @param array $datas
     * @return array|bool|string
     */
    public function create($datas = null)
    {
        $this->datas($datas);

        if (!empty($this->datas)) {
            $id = $this->QB()->insert($this->datas);
            if ($id) {
                $attr_id = static::ID;
                $this->$attr_id = $id;
                return $id;
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function createOrUpdate()
    {
        if ($this->exist()) {
            return $this->update();
        } else {
            if (!is_null(static::STATE)) {
                $this->data(static::STATE, static::_STATE_ENABLED);
            }
            return $this->create();
        }
    }

    public function createOrUpdateRSP()
    {
        if ($this->exist()) {
            if ($this->update()) {
                Log::add(Log::UPDATE, Auth::id(), $this->getID(), $this->table);
                return rsp(true)->set('id', $this->getID());
            } else {
                return rsp('Error interno :: DB :: insert');
            }
        } else {
            if (!is_null(static::STATE)) {
                $this->data(static::STATE, static::_STATE_ENABLED);
            }
            if ($this->create()) {
                Log::add(Log::CREATE, Auth::id(), $this->getID(), $this->table);
                return rsp(true)->set('id', $this->getID());
            } else {
                return rsp('Error interno :: DB :: insert');
            }
        }
    }

    public static function deleteRSP($id, $forever = false)
    {
        $item = static::find($id);
        if ($item->exist()) {
            if ($item->delete($forever)) {
                Log::add(Log::DELETE, Auth::id(), $id, $item->table);
                return rsp(true);
            } else return rsp('Error interno :: DB');
        } else return rsp('No se pudo reconocer');
    }

    public function delete($forever = false)
    {
        if ($this->exist()) {
            if ($forever) {
                return $this->QB()
                    ->where(static::ID, '=', $this->getID())
                    ->delete();
            } else {
                $this->data(static::STATE, static::_STATE_DELETED);
                if (!is_null(static::DATE_DELETED)) {
                    $this->data(static::DATE_DELETED, QB::raw('NOW()'));
                }
                return $this->update();
            }
        }
        return false;
    }

    public function getID()
    {
        $attr_id = static::ID;
        return isset($this->$attr_id) ? $this->$attr_id : '';
    }

    /**
     * @return bool
     */
    public function exist()
    {
        return !empty($this->getID());
    }

    /* @return QB */
    public function QB()
    {
        return QB::table($this->table);
    }

}