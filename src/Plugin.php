<?php
/**
 * Plugin.php
 * @author cdyun(121625706@qq.com)
 * @date 2026/3/12 15:16
 */

declare (strict_types=1);

namespace think\composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Util\Platform;

class Plugin implements PluginInterface
{
    /**
     * @param \Composer\Composer $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {

        // 根应用包
        $package = $this->addServer($composer)->getPackage();

        // 注册安装器
        $composer->getInstallationManager()->addInstaller(new Installer($io, $composer));

        // 读取根应用配置
        $config = json_decode(file_get_contents('composer.json'), true);
        if (empty($config['type']) && empty($config['name'])) {
            method_exists($package, 'setType') && $package->setType('project');
        }

        // 读取项目根参数
        if ($package->getType() === 'project') {

            // 注册自动加载
            $auto = $package->getAutoload();
            if (empty($auto)) $package->setAutoload([
                'psr-0' => ['' => 'extend'], 'psr-4' => ['app\\' => 'app'],
            ]);

        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    /**
     * 增加插件服务 ( 需上报应用标识信息 )
     * @param \Composer\Composer $composer
     * @return \Composer\Composer
     */
    private function addServer(Composer $composer): Composer
    {
        return $composer;
    }
}