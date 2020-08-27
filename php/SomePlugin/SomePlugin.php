<?php declare(strict_types=1);

namespace SomePlugin;


use SomePlugin\Service\MigrationService;
use Shopware\Core\Framework\Parameter\AdditionalBundleParameters;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context as PluginContext;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SomePlugin extends Plugin
{
    
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
    
    public function install(InstallContext $installContext): void
    {
        $migrationService = new MigrationService($this->container);
        $migrationService->createAdditions($this->_getClass(true));
        $migrationService->installMigrations($installContext);
    }
    
    public function postInstall(PluginContext\InstallContext $installContext): void
    {
    }
    
    public function update(UpdateContext $updateContext): void
    {
    
    }
    
    public function postUpdate(UpdateContext $updateContext): void
    {
    }
    
    public function activate(ActivateContext $activateContext): void
    {
    }
    
    public function deactivate(DeactivateContext $deactivateContext): void
    {
    }
    
    
    public function uninstall(PluginContext\UninstallContext $uninstallContext): void
    {
        $withdrawMigrationService = new MigrationService($this->container);
        $withdrawMigrationService->createWithdrawals($this->_getClass(true));
        $withdrawMigrationService->uninstallMigrations($uninstallContext);
    }
    
    
    /**
     * @param bool $namespace - if true getting first part of namespace
     *
     * @return string
     */
    private function _getClass(bool $namespace = false): string
    {
        $classNameParts = explode('\\', __CLASS__);
        
        if ($namespace) {
            return array_shift($classNameParts);
        } else {
            return array_pop($classNameParts);
        }
    }
    
}
