<?php
/*
 * The MIT License
 *
 * Copyright 2015 Anthony Maudry <amaudry@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Thuata\FrameworkBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineEntityCommand;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * <b>EntityStackGeneratorCommand</b><br>
 * Command to generate a full entity stack :
 * <ul><li>The entity</li>
 * <li>Its manager</li>
 * <li>Its repository</li></ul>
 *
 * @package Thuata\FrameworkBundle\Command
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class EntityStackGeneratorCommand extends GenerateDoctrineEntityCommand
{
    const NAME = 'thuata:generate:entity';
    const ALIAS = 'thuata:entity:generate';
    const DESCRIPTION = 'Generates a Thuata Framework entity';

    /**
     * Configuration
     */
    protected function configure()
    {
        parent::configure();

        $this->setName(self::NAME);
        $this->setAliases([self::ALIAS]);
        $this->setHelp(sprintf(<<<EOT
The <info>thuata:generate:entity</info> command Generates a full stack for a doctrine entity,
including a mamanger and a repository.

%s
EOT
        , $this->getHelp()));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $entityName = Validators::validateEntityName($input->getOption('entity'));
        list($bundleName, $entity) = $this->parseShortcutNotation($entityName);

        $bundle = $this->getContainer()->get('kernel')->getBundle($bundleName);

        $generator = $this->getContainer()->get('thuata_framework.stackgeneratorservice');

        $generator->renderEntityStack($bundle, $entity);
    }

}