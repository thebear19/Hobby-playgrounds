package org;
import javax.swing.*;
public class Start
{
	public static void main(String[] args)
	{
		//แสดงหน้าต่างเกม
		new BoardGame().setVisible(true);
		//แสดงข้อความออก dialog
		JOptionPane.showMessageDialog(null,"Welcome to MakKham game");
		//แสดงข้อความออก dialog
		JOptionPane.showMessageDialog(null,"Press Start to play game");
	}
}