package org;
import javax.swing.*;
public class Score
{
	private int sW=0,sB=0;//�纤�ṹ���2����
	private int[] i={0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0};//�������� ������µ�ǹ����ա�ùѺ��ṹ������ѧ
	
	//����ФԴ��ṹ���¢��
	public void ScoreW(int PosY,int i)
	{
		//��ҵ�����µ�ǹ�� ����㹵��˹� 2����ҧ�ͧ��дҹ ����ѧ����¤Դ��ṹ
		if(PosY>=6 && this.i[i]==0)
		{
			sW++;//������ṹ�1���
			this.i[i] = 1;//�������ҵ�����µ�ǹ�鹤Դ��ṹ���º��������
		}
		CheakWin();
	}
	//����ФԴ��ṹ���´�
	public void ScoreB(int PosY,int i)
	{
		//��ҵ�����µ�ǹ�� ����㹵��˹� 2�Ǻ��ͧ��дҹ ����ѧ����¤Դ��ṹ
		if(PosY<=1 && this.i[i]==0)
		{
			sB++;//������ṹ�1���
			this.i[i] = 1;//�������ҵ�����µ�ǹ�鹤Դ��ṹ���º��������
		}
		CheakWin();
	}
	//�礡���骹�
	public void CheakWin()
	{
		//��Ҥ�ṹ���¢�Ƕ֧8 �����¢�Ǫ��
		if(sW==8)
			JOptionPane.showMessageDialog(null,"WINNER IS WHITE !!");
		//������ �����ҽ��´Ӥ�ṹ�֧8�����ѧ
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
	//�ӡ������ ����礡�ùѺ��ṹ������
	public void reI() {
		for(int x=0;x<i.length;x++)
			i[x]=0;
	}
}