package org;
import javax.swing.*;
public class Start
{
	public static void main(String[] args)
	{
		//�ʴ�˹�ҵ�ҧ��
		new BoardGame().setVisible(true);
		//�ʴ���ͤ����͡ dialog
		JOptionPane.showMessageDialog(null,"Welcome to MakKham game");
		//�ʴ���ͤ����͡ dialog
		JOptionPane.showMessageDialog(null,"Press Start to play game");
	}
}