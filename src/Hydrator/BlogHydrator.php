<?php
declare(strict_types=1);


namespace App\Hydrator;

use App\DTO\Blog;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use Exception;
use JsonException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class BlogHydrator
 * @package App\Hydrator
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class BlogHydrator extends AbstractHydrator
{
    /**
     * @var PropertyAccessor
     */
    protected PropertyAccessor $propertyAccessor;

    /**
     * @var PropertyInfoExtractor
     */
    protected PropertyInfoExtractor $propertyInfo;

    /**
     * AbstractHydrator constructor.
     *
     * @param EntityManagerInterface $em
     * @param string                 $dtoClass
     */
    public function __construct(EntityManagerInterface $em, private readonly string $dtoClass = Blog::class)
    {
        parent::__construct($em);
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableMagicMethods()
            ->getPropertyAccessor();
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $listExtractors = [$reflectionExtractor];
        $typeExtractors = [$phpDocExtractor, $reflectionExtractor];
        $descriptionExtractors = [$phpDocExtractor];
        $accessExtractors = [$reflectionExtractor];
        $propertyInitializableExtractors = [$reflectionExtractor];
        $this->propertyInfo = new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            $descriptionExtractors,
            $accessExtractors,
            $propertyInitializableExtractors
        );
    }

    /**
     * @param string      $key
     * @param mixed       $value
     * @param string|null $dtoClass
     * @return mixed
     * @throws JsonException
     */
    protected function getValue(string $key, mixed $value, string $dtoClass = null): mixed
    {
        $types = $this->propertyInfo->getTypes($dtoClass, $key);
        if (is_array($types) && count($types) > 0) {
            if (
                $types[0]->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT
                &&
                in_array($types[0]->getClassName(), [
                    DateTime::class,
                    DateTimeImmutable::class,
                ], true)) {
                $class = $types[0]->getClassName();

                return new $class($value);
            }
            if ($types[0]->getBuiltinType() === Type::BUILTIN_TYPE_ARRAY) {
                return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            }
        }

        return $value;
    }


    /**
     * @inheritDoc
     * @return array
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     */
    protected function hydrateAllData(): array
    {
        $results = [];
        foreach ($this->_stmt->fetchAllAssociative() as $row) {
            $this->hydrateRowData($row, $results);
        }

        return $results;
    }


    /**
     * @param array $row
     * @param array $result
     * @return void
     * @throws Exception
     */
    protected function hydrateRowData(array $row, array &$result): void
    {
        $dto = new $this->dtoClass();
        $class = null;
        foreach ($row as $key => $value) {
            if (null !== $finalValue = $value) {
                $properties = explode('_', $this->_rsm->getScalarAlias($key));
                if (count($properties) > 0) {
                    if (count($properties) === 1) {
                        if ($this->propertyAccessor->isWritable($dto, $properties[0])) {
                            $finalValue = $this->getValue($properties[0], $finalValue, $this->dtoClass);
                            $this->propertyAccessor->setValue($dto, $properties[0], $finalValue);
                        }
                        continue;
                    }
                    $alias = [];
                    $path = '';
                    $count = count($properties) - 1;
                    foreach ($properties as $property) {
                        $alias[] = $property;
                        $path = implode('.', $alias);
                        if (null === $types = $this->propertyInfo->getTypes($this->dtoClass, $path)) {
                            $previous = $alias;
                            unset($previous[count($alias) - 1]);
                            if (null !== $previousType = $this->propertyInfo->getTypes($this->dtoClass, implode('.', $previous))) {
                                $types = $this->propertyInfo->getTypes($previousType[0]->getClassName(), $property);
                            }
                        }
                        if (is_array($types)
                            && isset($types[0])
                            && $types[0]->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT
                            && $this->propertyAccessor->getValue($dto, $path) === null
                            && !in_array($types[0]->getClassName(), [
                                DateTimeInterface::class,
                                DateTime::class,
                                DateTimeImmutable::class,
                            ], true)
                        ) {
                            $class = $types[0]->getClassName();
                            $this->propertyAccessor->setValue($dto, $path, new $class());
                        }
                    }
                    $finalValue = $this->getValue($properties[$count], $finalValue, $class);
                    $this->propertyAccessor->setValue($dto, $path, $finalValue);
                }
            }
        }
        $result[] = $dto;
    }
}
