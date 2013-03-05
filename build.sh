#!/bin/sh
# Argument = -n namespace -p plugin

REPLACENAMESPACE="{{THEME_NAMESPACE}}"
REPLACENAME="{{THEME_NAME}}"
REPLACEDISPLAYNAME="{{THEME_DISPLAY_NAME}}"
REPLACEDESCRIPTION="{{THEME_DESCRIPTION}}"
REPLACEURI="{{THEME_URI}}"

usage()
{
cat << EOF
usage: $0 options

OPTIONS:
   -h      Show this message
   -n      The namespace of the theme
   -p      The name of the theme
EOF
}

NAMESPACE=
NAME=
DISPLAYNAME=
DESCRIPTION=
URI=
while getopts "hn:p:" OPTION
do
     case $OPTION in
         h)
             usage
             exit 1
             ;;
         n)
             NAMESPACE=$OPTARG
             ;;
         p)
             NAME=$OPTARG
             ;;
         ?)
             usage
             exit
             ;;
     esac
done

if [[ -z $NAMESPACE ]] || [[ -z $NAME ]]
then
     usage
     exit 1
fi

# Rename all directories and files
find . -depth -name '*{{THEME_NAMESPACE}}*' -execdir bash -c 'mv -i "$1" "${1/$2/$3}"' bash {} $REPLACENAMESPACE $NAMESPACE \;
find . -depth -name '*{{THEME_NAME}}*' -execdir bash -c 'mv -i $1 ${1/$2/$3}' bash {} $REPLACENAME $NAME \;

# # Rename all instances inside of files.
find . -depth -type f \( -name "*.php" -o -name "*.xml" \) -execdir sed -i "" "s/$REPLACENAMESPACE/$NAMESPACE/g" {} \;
find . -depth -type f \( -name "*.php" -o -name "*.xml" \) -execdir sed -i "" "s/$REPLACENAME/$NAME/g" {} \;

if [[ -n $DISPLAYNAME ]]
then
    find . -depth -type f \( -name "*.php" -o -name "*.xml" \) -execdir sed -i "" "s/$REPLACEDISPLAYNAME/$DISPLAYNAME/g" {} \;
fi

if [[ -n $DESCRIPTION ]]
then
    find . -depth -type f \( -name "*.php" -o -name "*.xml" \) -execdir sed -i "" "s/$REPLACEDESCRIPTION/$DESCRIPTION/g" {} \;
fi

if [[ -n $URI ]]
then
    find . -depth -type f \( -name "*.php" -o -name "*.xml" \) -execdir sed -i "" "s/$REPLACEURI/$URI/g" {} \;
fi
