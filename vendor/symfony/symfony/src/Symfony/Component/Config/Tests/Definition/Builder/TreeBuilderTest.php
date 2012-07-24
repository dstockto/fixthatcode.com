<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Config\Tests\Definition\Builder;

use Symfony\Component\Config\Tests\Definition\Builder\NodeBuilder as CustomNodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

require __DIR__.'/../../Fixtures/Builder/NodeBuilder.php';
require __DIR__.'/../../Fixtures/Builder/BarNodeDefinition.php';
require __DIR__.'/../../Fixtures/Builder/VariableNodeDefinition.php';

class TreeBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testUsingACustomNodeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('custom', 'array', new CustomNodeBuilder());

        $nodeBuilder = $root->children();

        $this->assertEquals(get_class($nodeBuilder), 'Symfony\Component\Config\Tests\Definition\Builder\NodeBuilder');

        $nodeBuilder = $nodeBuilder->arrayNode('deeper')->children();

        $this->assertEquals(get_class($nodeBuilder), 'Symfony\Component\Config\Tests\Definition\Builder\NodeBuilder');
    }

    public function testOverrideABuiltInNodeType()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('override', 'array', new CustomNodeBuilder());

        $definition = $root->children()->variableNode('variable');

        $this->assertEquals(get_class($definition), 'Symfony\Component\Config\Tests\Definition\Builder\VariableNodeDefinition');
    }

    public function testAddANodeType()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('override', 'array', new CustomNodeBuilder());

        $definition = $root->children()->barNode('variable');

        $this->assertEquals(get_class($definition), 'Symfony\Component\Config\Tests\Definition\Builder\BarNodeDefinition');
    }

    public function testCreateABuiltInNodeTypeWithACustomNodeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('builtin', 'array', new CustomNodeBuilder());

        $definition = $root->children()->booleanNode('boolean');

        $this->assertEquals(get_class($definition), 'Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition');
    }

    public function testPrototypedArrayNodeUseTheCustomNodeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('override', 'array', new CustomNodeBuilder());

        $root->prototype('bar')->end();
    }

    public function testAnExtendedNodeBuilderGetsPropagatedToTheChildren()
    {
        $builder = new TreeBuilder();

        $builder->root('propagation')
            ->children()
                ->setNodeClass('extended', 'Symfony\Component\Config\Tests\Definition\Builder\VariableNodeDefinition')
                ->node('foo', 'extended')->end()
                ->arrayNode('child')
                    ->children()
                        ->node('foo', 'extended')
                    ->end()
                ->end()
            ->end()
        ->end();
    }

    public function testDefinitionInfoGetsTransferedToNode()
    {
        $builder = new TreeBuilder();

        $builder->root('test')->setInfo('root info')
            ->children()
                ->node('child', 'variable')->setInfo('child info')->defaultValue('default')
            ->end()
        ->end();

        $tree = $builder->buildTree();
        $children = $tree->getChildren();

        $this->assertEquals('root info', $tree->getInfo());
        $this->assertEquals('child info', $children['child']->getInfo());
    }

    public function testDefinitionExampleGetsTransferedToNode()
    {
        $builder = new TreeBuilder();

        $builder->root('test')
            ->setExample(array('key' => 'value'))
            ->children()
                ->node('child', 'variable')->setInfo('child info')->defaultValue('default')->setExample('example')
            ->end()
        ->end();

        $tree = $builder->buildTree();
        $children = $tree->getChildren();

        $this->assertTrue(is_array($tree->getExample()));
        $this->assertEquals('example', $children['child']->getExample());
    }
}
