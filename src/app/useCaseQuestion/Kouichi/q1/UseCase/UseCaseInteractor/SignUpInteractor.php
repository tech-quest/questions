<?php
namespace App\useCaseQuestion\Kouichi\q1\UseCase\UseCaseInteractor;

use App\useCaseQuestion\Kouichi\q1\UseCase\UseCaseInput\SignUpInput;
use App\useCaseQuestion\Kouichi\q1\UseCase\UseCaseOutput\SignUpOutput;
use App\useCaseQuestion\Kouichi\q1\Infrastructure\Dao\UserDao;

final class SignUpInteractor
{
    const ALLREADY_EXISTS_MESSAGE = 'すでに登録済みのメールアドレスです';
    const COMPLETED_MESSAGE = '登録が完了しました';

    private $useCaseInput;

    public function __construct(SignUpInput $useCaseInput)
    {
        $this->useCaseInput = $useCaseInput;
    }

    public function handler(): SignUpOutput
    {
        $userDao = new UserDao();
        $user = $userDao->findByEmail($this->useCaseInput->email()->value());

        if (!is_null($user)) {
            return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
        }

        $userDao->create(
            $this->useCaseInput->name()->value(),
            $this->useCaseInput->email()->value(),
            $this->useCaseInput->password()->value()
        );
        return new SignUpOutput(true, self::COMPLETED_MESSAGE);
    }
}
