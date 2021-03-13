<?php
declare(strict_types=1);


namespace app\modules\cart\factory\cart;


use app\modules\delivery\account\AccountService;
use app\modules\delivery\method\MethodService;
use app\modules\delivery\modules\_base\calculator\CalculatorInterface;
use app\modules\delivery\modules\_base\MethodFieldValidator;
use app\modules\delivery\service\ServiceService;

class CartDeliveryCalculatorFactory
{

    private $serviceAccount;
    private $serviceMethod;
    private $serviceService;

    private $calculator;
    private $validator;


    public function __construct(AccountService $serviceAccount, MethodService $serviceMethod, ServiceService $serviceService)
    {
        $this->serviceAccount = $serviceAccount;
        $this->serviceMethod  = $serviceMethod;
        $this->serviceService = $serviceService;
    }

    /**
     * @param string $code
     * @param int $id
     * @param array|null $fields
     */
    public function createCalculatorValidator(string $code, int $id, ?array $fields): void
    {
        $serviceEntity = $this->serviceService->get($code);
        $accountEntity = $this->serviceAccount->getByService($serviceEntity);
        $methodEntity  = $this->serviceMethod->getByService($serviceEntity, $id);

        $this->calculator = $this->serviceService->getModuleCalculator($serviceEntity, $accountEntity, $methodEntity, $fields);
        $this->validator  = $this->serviceService->getModuleFieldsValidator($serviceEntity);
    }

    /**
     * @return CalculatorInterface
     */
    public function getCalculator(): CalculatorInterface
    {
        return $this->calculator;
    }

    /**
     * @return MethodFieldValidator
     */
    public function getValidator(): MethodFieldValidator
    {
        return $this->validator;
    }
}
