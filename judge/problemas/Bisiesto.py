for i in range(0, 3):
   an1  = raw_input("");
   an1 = int(an1);
   if (an1 % 4 == 0 and an1 % 100 != 0) or (an1 % 100 and an1 % 400 == 0):
      print "Es bisiesto";
   else:
      print "No es bisiesto";