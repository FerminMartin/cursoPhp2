<?php

namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'No version set (parsed as 1.0.0)',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'No version set (parsed as 1.0.0)',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'aura/router' => 
    array (
      'pretty_version' => '3.1.0',
      'version' => '3.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '52507bc813c92511dbcacc7463f163ef5149ad38',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => 'v1.1.0',
      'version' => '1.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '90b2128806bfde671b6952ab8bea493942c1fdae',
    ),
    'illuminate/container' => 
    array (
      'pretty_version' => 'v5.4.36',
      'version' => '5.4.36.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c5b8a02a34a52c307f16922334c355c5eef725a6',
    ),
    'illuminate/contracts' => 
    array (
      'pretty_version' => 'v5.4.36',
      'version' => '5.4.36.0',
      'aliases' => 
      array (
      ),
      'reference' => '67f642e018f3e95fb0b2ebffc206c3200391b1ab',
    ),
    'illuminate/database' => 
    array (
      'pretty_version' => 'v5.4.36',
      'version' => '5.4.36.0',
      'aliases' => 
      array (
      ),
      'reference' => '405aa061a5bc8588cbf3a78fba383541a568e3fe',
    ),
    'illuminate/support' => 
    array (
      'pretty_version' => 'v5.4.36',
      'version' => '5.4.36.0',
      'aliases' => 
      array (
      ),
      'reference' => 'feab1d1495fd6d38970bd6c83586ba2ace8f299a',
    ),
    'kylekatarnls/update-helper' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '429be50660ed8a196e0798e5939760f168ec8ce9',
    ),
    'laminas/laminas-diactoros' => 
    array (
      'pretty_version' => '1.8.7p2',
      'version' => '1.8.7.0-patch2',
      'aliases' => 
      array (
      ),
      'reference' => '6991c1af7c8d2c8efee81b22ba97024781824aaa',
    ),
    'laminas/laminas-zendframework-bridge' => 
    array (
      'pretty_version' => '1.0.4',
      'version' => '1.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fcd87520e4943d968557803919523772475e8ea3',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '1.39.1',
      'version' => '1.39.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4be0c005164249208ce1b5ca633cd57bdd42ff33',
    ),
    'paragonie/random_compat' => 
    array (
      'pretty_version' => 'v2.0.18',
      'version' => '2.0.18.0',
      'aliases' => 
      array (
      ),
      'reference' => '0a58ef6e3146256cc3dc7cc393927bcc7d1b72db',
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.17.1',
      'version' => '1.17.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '7110338d81ce1cbc3e273136e4574663627037a7',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v3.4.42',
      'version' => '3.4.42.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b0cd62ef0ff7ec31b67d78d7fc818e2bda4e844f',
    ),
    'tightenco/collect' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'zendframework/zend-diactoros' => 
    array (
      'replaced' => 
      array (
        0 => '~1.8.7.0',
      ),
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
