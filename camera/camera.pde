// Need G4P library
import g4p_controls.*;
import processing.video.*;
Capture cam;
String type="clear";
PImage tmp=createImage(640,480,RGB);
public void setup(){
  size(720, 480, JAVA2D);
  createGUI();
  customGUI();
  // Place your setup code here
  String[] cameras=Capture.list();
  if(cameras.length==0)exit();
  cam=new Capture(this,cameras[0]);
  cam.start();
}

public void draw(){
  background(230);
  if(cam.available()==true) cam.read();
  makeChange();
  image(cam,0,0,640,480);
}
public void makeChange(){
  if(type=="clear"){cam.start();return;}
  if(type=="stop"){cam.stop();return;}
  if(type=="invert"){
    for(int x=0;x<640*480;x++)
     cam.pixels[x]=-1-cam.pixels[x];
     return;
 } 
 if(type=="relief"){
   for(int x=641;x<640*480-641;x++)
     tmp.pixels[x]=cam.pixels[x-641]-cam.pixels[x+641];
   for(int x=0;x<640*480;x++)
     cam.pixels[x]=tmp.pixels[x];
   return;
 }
 if(type=="old"){
   int t;
   for(int x=0;x<640*480;x++){
     t=cam.pixels[x];
     cam.pixels[x]=color(
     red(t)*0.393+green(t)*0.769+blue(t)*0.189,
     red(t)*0.349+green(t)*0.686+blue(t)*0.168,
     red(t)*0.272+green(t)*0.534+blue(t)*0.131
     );
   }
   return;
 }
}
// Use this method to add additional statements
// to customise the GUI controls
public void customGUI(){

}
