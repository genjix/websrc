ARG="eq-base-fore4.png"
FORE="../eq-base-bg.png"
LOADBAR="../eq-base-load.png"

mkdir tmp
cd tmp
ARG="../$ARG"

convert -crop +0-116 $ARG stage1.png
convert -crop +0-93 $ARG stage2.png
convert -crop +0-70 $ARG stage3.png
convert -crop +0-47 $ARG stage4.png
convert -crop +0-25 $ARG stage5.png

composite stage1.png $FORE eq-comp1.png
composite stage2.png $FORE eq-comp2.png
composite stage3.png $FORE eq-comp3.png
composite stage4.png $FORE eq-comp4.png
composite stage5.png $FORE eq-comp5.png
composite $ARG $FORE eq-comp6.png

composite -geometry +5+13 $LOADBAR eq-comp1.png eq-comp1.png
composite -geometry +5+36 $LOADBAR eq-comp2.png eq-comp2.png
composite -geometry +5+59 $LOADBAR eq-comp3.png eq-comp3.png
composite -geometry +5+82 $LOADBAR eq-comp4.png eq-comp4.png
composite -geometry +5+104 $LOADBAR eq-comp5.png eq-comp5.png
composite -geometry +5+116 $LOADBAR eq-comp6.png eq-comp6.png

composite $ARG $FORE eq-comp.png

convert -loop 0 -delay 400 $FORE -delay 10  eq-comp1.png eq-comp2.png \
  eq-comp3.png eq-comp4.png eq-comp5.png eq-comp6.png -delay 500 \
  eq-comp.png -delay 10 $FORE eq-comp.png $FORE eq.gif
