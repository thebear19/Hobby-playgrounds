package org;
import javax.swing.*;
public class Score
{
	private int sW=0,sB=0;//เก็บคะแนนทั้ง2ฝ่าย
	private int[] i={0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0};//ตัวเช็คว่า ตัวเบี้ยตัวนั้นๆมีการนับคะแนนไปหรือยัง
	
	//เช็คและคิดคะแนนฝ่ายขาว
	public void ScoreW(int PosY,int i)
	{
		//ถ้าตัวเบี้ยตัวนั้น อยู่ในตำแหน่ง 2แถวล่างของกระดาน และยังไม่เคยคิดคะแนน
		if(PosY>=6 && this.i[i]==0)
		{
			sW++;//เพิ่มคะแนนไป1แต้ม
			this.i[i] = 1;//เซ็ตให้ว่าตัวเบี้ยตัวนั้นคิดคะแนนเรียบร้อยแล้ว
		}
		CheakWin();
	}
	//เช็คและคิดคะแนนฝ่ายดำ
	public void ScoreB(int PosY,int i)
	{
		//ถ้าตัวเบี้ยตัวนั้น อยู่ในตำแหน่ง 2แถวบนของกระดาน และยังไม่เคยคิดคะแนน
		if(PosY<=1 && this.i[i]==0)
		{
			sB++;//เพิ่มคะแนนไป1แต้ม
			this.i[i] = 1;//เซ็ตให้ว่าตัวเบี้ยตัวนั้นคิดคะแนนเรียบร้อยแล้ว
		}
		CheakWin();
	}
	//เช็คการแพ้ชนะ
	public void CheakWin()
	{
		//ถ้าคะแนนฝ่ายขาวถึง8 ให้ฝ่ายขาวชนะ
		if(sW==8)
			JOptionPane.showMessageDialog(null,"WINNER IS WHITE !!");
		//ถ้าไม่ เช็ค่ว่าฝ่ายดำคะแนนถึง8หรือยัง
		else if(sB==8)
			JOptionPane.showMessageDialog(null,"WINNER IS BLACK !!");
	}
	public int getsW() {
		return sW;
	}
	public void setsW(int sW) {
		this.sW = sW;
	}
	public int getsB() {
		return sB;
	}
	public void setsB(int sB) {
		this.sB = sB;
	}
	//ทำการรีเซ็ต ตัวเช็คการนับคะแนนทั้งหมด
	public void reI() {
		for(int x=0;x<i.length;x++)
			i[x]=0;
	}
}