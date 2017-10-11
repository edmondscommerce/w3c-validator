#!/usr/bin/env bash
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
done
DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
cd $DIR;
set -e
set -u
set -o pipefail
standardIFS="$IFS"
IFS=$'\n\t'
echo "
===========================================
$(hostname) $0 $@
===========================================
"
projectRoot=$(realpath ./../../../../)
cd $projectRoot;

if [[ "$(whoami)" != "root" ]]
then
    echo "Please run this as root"
    exit 1
fi

validatorBinUrl="https://github.com/validator/validator/releases/download/17.9.0/vnu.jar_17.9.0.zip";
validatorZipTargetPath="$DIR/validator.zip";
validatorBinTargetPath="$DIR/validator.jar";

if [ -n "$(type -t java)" ]
then
    echo "Java command is available, continuing...";
else
    echo "Java not installed, installing Java";
    yum install java -y;
fi

if [[ -n "$(type -t unzip)" ]]
then
    echo "Unzip command is available, continuing...";
else
    echo "Unzip not installed, installing unip";
    yum install unzip -y;
fi

if [[ ! -f $validatorBinTargetPath ]]
then
    #Download the validator binary and unzip if needed
    echo "Downloading validator binary archive to: $validatorZipTargetPath";
    wget -O $validatorZipTargetPath $validatorBinUrl;
    unzip -o "$validatorZipTargetPath" -d "$DIR";
    mv "$DIR/dist/vnu.jar" "$validatorBinTargetPath";
    chown ec:ec "$validatorBinTargetPath"
    echo "

    Validator downloaded and installed

    ";

else
    echo "Found validator, no action required";
fi

exit 0;