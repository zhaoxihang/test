<?php

namespace app\application\Logic;
/**
 * jwt封装的一个简单的类
 */
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use DateTimeImmutable;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

class JwtLogic
{
    /**
     * 签发人
     * @var string
     */
    const ISSUED_BY = 'localhost';

    /**
     * 受众
     * @var string
     */
    const PERMITTED_FOR = 'localhost/user_id';
    /**
     * JWT ID 编号 唯一标识
     */
    const IDENTIFIED_BY = 'jwt_id_zhaoxihang';

    /**
     * 配置秘钥加密
     * @return Configuration
     */
    public static function getConfig()
    {
        $configuration = Configuration::forSymmetricSigner(
        // You may use any HMAC variations (256, 384, and 512)
            new Sha256(),
            // replace the value below with a key of your own!
            InMemory::base64Encoded('YWFhc0pOU0RLSkJITktKU0RiamhrMTJiM2Joa2ox')
        // You may also override the JOSE encoder/decoder if needed by providing extra arguments here
        );
        return $configuration;
    }
    /**
     * 签发令牌
     */
    public static function createToken($user_id)
    {
        $config = self::getConfig();
        if($config instanceof Configuration){
            $now = new DateTimeImmutable();
            $token = $config->builder()
                // 签发人
                ->issuedBy(static::ISSUED_BY)
                // 受众
                ->permittedFor(static::PERMITTED_FOR)
                // JWT ID 编号 唯一标识
                ->identifiedBy(static::IDENTIFIED_BY)
                // 签发时间
                ->issuedAt($now)
                // 在1分钟后才可使用
//            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
                // 过期时间1小时
                ->expiresAt($now->modify('+1 hour'))
                // 自定义uid 额外参数
                ->withClaim('user_id', $user_id)
                // 自定义header 参数
                ->withHeader('foo', 'bar')
                // 生成token
                ->getToken($config->signer(), $config->signingKey());
            return $token->toString();
        }
    }
    /**
     * 解析令牌
     */
    public static function parseToken(string $token)
    {
        $config = self::getConfig();
        assert($config instanceof Configuration);
        $token = $config->parser()->parse($token);
        assert($token instanceof Plain);
        return $token;
        dump($token->headers()); // Retrieves the token headers
        dump($token->claims()); // Retrieves the token claims
    }

    /**
     * 验证令牌
     * @param string $token
     * @param $user_id
     * @return bool
     */
    public static function validationToken(string $token ,$user_id)
    {
        $config = self::getConfig();
        if($config instanceof Configuration){
            $token = $config->parser()->parse($token);
            if($token instanceof Plain){
                //Lcobucci\JWT\Validation\Constraint\IdentifiedBy: 验证jwt id是否匹配
                //Lcobucci\JWT\Validation\Constraint\IssuedBy: 验证签发人参数是否匹配
                //Lcobucci\JWT\Validation\Constraint\PermittedFor: 验证受众人参数是否匹配
                //Lcobucci\JWT\Validation\Constraint\RelatedTo: 验证自定义cliam参数是否匹配
                //Lcobucci\JWT\Validation\Constraint\SignedWith: 验证令牌是否已使用预期的签名者和密钥签名
                //Lcobucci\JWT\Validation\Constraint\StrictValidAt: ：：验证存在及其有效性的权利要求中的iat，nbf和exp（支持余地配置
                //Lcobucci\JWT\Validation\Constraint\LooseValidAt: 验证的权利要求iat，nbf和exp，当存在时（支持余地配置）
                //验证jwt id是否匹配
                $validate_jwt_id = new \Lcobucci\JWT\Validation\Constraint\IdentifiedBy(static::IDENTIFIED_BY);
                $config->setValidationConstraints($validate_jwt_id);
                //验证签发人url是否正确
                $validate_issued = new \Lcobucci\JWT\Validation\Constraint\IssuedBy(static::ISSUED_BY);
                $config->setValidationConstraints($validate_issued);
                //验证客户端url是否匹配
                $validate_aud = new \Lcobucci\JWT\Validation\Constraint\PermittedFor(static::PERMITTED_FOR);
                $config->setValidationConstraints($validate_aud);
                $constraints = $config->validationConstraints();
                try {
                    $config->validator()->assert($token, ...$constraints);
                    return true;
                } catch (RequiredConstraintsViolated $e) {
                    // list of constraints violation exceptions:
                    var_dump($e->violations());
                }
            }
        }
        return false;
    }
}