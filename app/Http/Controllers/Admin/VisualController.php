<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Controllers\ResourceController;
use App\Visual;
use Illuminate\Http\Request;

class VisualController extends Controller
{

    use ResourceController;

    /**
     * @var string
     */
    protected $resourceAlias = 'admin.visuals';

    /**
     * @var string
     */
    protected $resourceRoutesAlias = 'admin::visuals';

    /**
     * Fully qualified class name
     *
     * @var string
     */
    protected $resourceModel = Visual::class;

    /**
     * @var string
     */
    protected $resourceTitle = 'Visuals';

    /**
     * Used to validate store.
     *
     * @return array
     */
    private function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|min:3|max:255|unique:visuals,name',
            ],
            'messages' => [],
            'attributes' => [],
        ];
    }

    /**
     * Used to validate update.
     *
     * @param $record
     * @return array
     */
    private function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|min:3|max:255',
            ],
            'messages' => [],
            'attributes' => [],
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param null $record
     * @return array
     */
    private function getValuesToSave(Request $request, $record = null)
    {
        $creating = is_null($record);
        $values = [];
        $values['name'] = $request->input('name', '');
        $path=strtolower($values['name']);
        $values['path'] = preg_replace('/\s+/', '', $path);
        return $values;
    }

    private function alterValuesToSave(Request $request, $values)
    {
        return $values;
    }

    /**
     * @param $record
     * @return bool
     */
    private function checkDestroy($record)
    {
        return true;
    }

    /**
     * Retrieve the list of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $show
     * @param string|null $search
     * @return \Illuminate\Support\Collection
     */
    private function getSearchRecords(Request $request, $show = 15, $search = null)
    {
        if (!empty($search)) {
            return $this->getResourceModel()::where('name', 'like' ,'%'.$search.'%')->paginate($show);
        }

        return $this->getResourceModel()::paginate($show);
    }
    private function updateRelations(Request $request, $id)
    {
        // $categorys sẽ lưu dữ liệu của các thẻ mới        
        $record = $this->getResourceModel()::findOrFail($id);
        $categorys = $request->input('categorys', '');
        $record->Categories()->sync($categorys);
    }
    private function detroyRelations($id)
    {      
      $record = $this->getResourceModel()::findOrFail($id);
      $record->Categories()->detach();
    }
}
