<?php

namespace Datacity\PublicBundle\Uploadable;

use Gedmo\Uploadable\FileInfo\FileInfoArray;
use Gedmo\Uploadable\FilenameGenerator\FilenameGeneratorAlphanumeric;
use Symfony\Component\Filesystem\Filesystem;

//A ne pas utiliser hors Fixture !
class FixtureImageInfo extends FileInfoArray
{
    public function __construct($url)
    {
        $fileNameGen = new FilenameGeneratorAlphanumeric();
        $this->fileInfo = array(
            'tmp_name'      => '',
            'name'          => $fileNameGen->generate(basename($url), '.jpg'), //Fausse extension .jpg mais pas important ici.
            'size'          => 0,
            'type'          => '',
            'error'         => 0
        );
        $fs = new Filesystem();
        if ($fs->exists(__DIR__.'/../../../../web/uploads/fixture/') === false)
            $fs->mkdir(__DIR__.'/../../../../web/uploads/fixture/');
        $this->fileInfo['tmp_name'] = __DIR__.'/../../../../web/uploads/fixture/' . $this->fileInfo['name'];
        if ($fs->exists($this->fileInfo['tmp_name']) === false)
        {
            $file = file_get_contents($url);
            $this->fileInfo['size'] = file_put_contents($this->fileInfo['tmp_name'], $file);
        }
    }

    public function isUploadedFile()
    {
        return false;
    }
}