<?php

namespace LeMike\PhpSpec\WpExtension\Locator\WordPress;

use InvalidArgumentException;
use PhpSpec\Locator\ResourceLocatorInterface;
use PhpSpec\Util\Filesystem;

class WpLocator extends AbstractResourceLocator implements ResourceLocatorInterface
{
    protected $classType = 'Model';

    protected $validator = '/^(model):([a-zA-Z0-9]+)_([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)(_[\w]+)?$/';

	public function __construct($srcNamespace = '', $specNamespacePrefix = '',
		$srcPath = 'src', $specPath = 'spec', Filesystem $filesystem = null)
	{
		$this->filesystem = $filesystem ? : new Filesystem;
		$this->srcPath       = rtrim(realpath($srcPath), '/\\') . DIRECTORY_SEPARATOR;
		$this->specPath      = rtrim(realpath($specPath), '/\\') . DIRECTORY_SEPARATOR;
		$this->srcNamespace  = ltrim(trim($srcNamespace, ' \\') . '\\', '\\');
		$this->specNamespace = trim($specNamespacePrefix, ' \\') . '\\';
		$this->fullSrcPath   = $this->srcPath;
		$this->fullSpecPath  = $this->specPath;

		if (DIRECTORY_SEPARATOR === $this->srcPath) {
			throw new \InvalidArgumentException(sprintf(
				'Source code path should be existing filesystem path, but "%s" given.',
				$srcPath
			));
		}

		if (DIRECTORY_SEPARATOR === $this->specPath) {
			throw new \InvalidArgumentException(sprintf(
				'Specs code path should be existing filesystem path, but "%s" given.',
				$specPath
			));
		}
	}


	/**
     * @return int
     */
    public function getPriority()
    {
        return 40;
    }

    /**
     * @param string $file
     * @return bool
     */
    protected function isSupported($file)
    {
	    // TODO wann?        return strpos($file, 'Model') > 0;

	    return true;
    }

	public function supportsQuery( $query ) {
		return true;
		return parent::supportsQuery( $query ); // TODO: Change the autogenerated stub
	}


	/**
     * @param array $parts
     * @param ResourceLocatorInterface $locator
     *
*@return WpResource
     * @throws \InvalidArgumentException
     */
    protected function getResource(array $parts, ResourceLocatorInterface $locator)
    {
        if (!$locator instanceof WpLocator) {
            throw new \InvalidArgumentException('WP resource requires a wp locator');
        }

        return new WpResource($parts, $locator);
    }
}