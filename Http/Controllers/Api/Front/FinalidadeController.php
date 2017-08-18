<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 17/02/2017
 * Time: 16:21
 */
namespace Modules\Anuncio\Http\Controllers\Api\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Anuncio\Criteria\FinalidadeCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\FinalidadeRequest;
use Modules\Anuncio\Repositories\FinalidadeRepository;
use Portal\Services\CacheService;
use Prettus\Repository\Exceptions\RepositoryException;

class FinalidadeController extends BaseController
{
    /**
     * @var FinalidadeRepository
     */
    private $finalidadeRepository;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(FinalidadeRepository $finalidadeRepository,
                                CacheService $cacheService)
    {
        parent::__construct($finalidadeRepository, FinalidadeCriteria::class);
        $this->finalidadeRepository = $finalidadeRepository;
        $this->cacheService = $cacheService;
    }

    public function selectFinalidades(){
        try{
            return $this->finalidadeRepository->all();
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }


    public function getList(){
        try{
            if($this->cacheService->has('todas_finalidades')){
                return $this->cacheService->get('todas_finalidades');
            }
            $data = $this->finalidadeRepository->findWhere(['parent_id'=>null]);
            $this->cacheService->put('todas_finalidades',$data,15);
            return $data;
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }
    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new FinalidadeRequest())->rules();
        return $this->validator;
    }
}