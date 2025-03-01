/****** Object:  Table [dbo].[S001]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[S001](
	[no_classify_cd] [nvarchar](10) NOT NULL,
	[no_classify_nm] [nvarchar](30) NULL,
	[no_num_or_char_div] [nvarchar](4) NULL,
	[no_prefix_char] [nvarchar](3) NULL,
	[serial_no] [bigint] NULL,
	[start_number] [bigint] NULL,
	[finish_number] [bigint] NULL,
	[no_digit] [int] NULL,
	[no_initial_type_div] [int] NULL,
	[remarks] [nvarchar](50) NULL,
	[cre_user_cd] [nvarchar](5) NULL,
	[cre_prg] [nvarchar](30) NULL,
	[cre_ip] [nvarchar](20) NULL,
	[cre_tm] [datetime2](7) NULL,
	[upd_user_cd] [nvarchar](5) NULL,
	[upd_prg] [nvarchar](30) NULL,
	[upd_ip] [nvarchar](20) NULL,
	[upd_tm] [datetime2](7) NULL,
	[del_user_cd] [nvarchar](5) NULL,
	[del_prg] [nvarchar](30) NULL,
	[del_ip] [nvarchar](20) NULL,
	[del_tm] [datetime2](7) NULL,
	[del_flg] [int] NULL,
 CONSTRAINT [PK_s_number] PRIMARY KEY CLUSTERED 
(
	[no_classify_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
