<?php declare(strict_types=1);

namespace SomePlugin\Service;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Shopware\Core\Framework\Plugin\Context as PluginContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MigrationService sample file
 *
 * @extends ServiceAbstract - abstract constructor defines used context and set up services
 *          through autowiring such as `Connection` required in this service
 * @descripition
 *          default Context is 'SystemSource', e.g. used in Terminal
 *          when this service is used by administration area browser context is different
 *          and terminal specific pieces are not executed
 */
class MigrationService extends ServiceAbstract
{
    private $container;
    
    private $additions = [];
    private $withdrawals = [];
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function createAdditions(string $pluginNamespace)
    {
        $this->additions[$pluginNamespace] = $this->getPluginMigrations($pluginNamespace, true);
    }
    
    public function createWithdrawals(string $pluginClassName)
    {
        $this->withdrawals[$pluginClassName] = $this->getPluginMigrations($pluginClassName);
    }
    
    private function getPluginMigrations($pluginNamespace, $isBeingInstalled = false)
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('class')
            ->from('migration')
            ->where('SUBSTRING_INDEX(class,"\\\\",1) = :contains')
            ->setParameter('contains', $pluginNamespace)
            ->orderBy('`update`', $isBeingInstalled ? 'ASC' : 'DESC');
        return $query->execute()->fetchAll(FetchMode::COLUMN);
    }
    
    /**
     * @param PluginContext\InstallContext $installContext
     */
    public function installMigrations(PluginContext\InstallContext $installContext)
    {
        $this->setContextName($installContext);
        
        if ($this->getContextName() === 'SystemSource') {
            echo "> Install migrations:\n";
        }
        foreach ($this->additions[$this->_getRefererPluginClass()] as $pluginMigration) {
            $migrationName = $this->getMigrationName($pluginMigration);
            $migrationObject = new $pluginMigration();
            
            if (method_exists($migrationObject, 'installMigration')) {
                if ($this->getContextName() === 'SystemSource') {
                    echo $migrationName;
                }
    
                /**
                 * Execute installMigration function defined in migration class
                 */
                $migrationObject->installMigration($this->connection, $this->getContextName(), $this->container);
            }
            
        }
    }
    
    /**
     * @param PluginContext\UninstallContext $uninstallContext
     */
    public function uninstallMigrations(PluginContext\UninstallContext $uninstallContext)
    {
        $this->setContextName($uninstallContext);
        
        $this->writeInfo("> Uninstall migrations:\n");
        foreach ($this->withdrawals[$this->_getRefererPluginClass()] as $pluginMigration) {
            $migrationName = $this->getMigrationName($pluginMigration);
            
            $migrationObject = new $pluginMigration();
            
            if (method_exists($migrationObject, 'uninstallMigration')) {
                if ($this->getContextName() === 'SystemSource') {
                    echo $migrationName;
                }
                
                /**
                 * Execute uninstallMigration function defined in migration class
                 */
                $migrationObject->uninstallMigration($this->connection, $this->getContextName(), $this->container);
            }
            
        }
    }
    
    private function _getRefererPluginClass(): string
    {
        $trace = debug_backtrace();
        return $trace[3]['args'][0]->getName();
    }
    
    private function getMigrationName($pluginMigration): string
    {
        $parts = explode('\\', $pluginMigration);
        return array_pop($parts);
    }
    
}
